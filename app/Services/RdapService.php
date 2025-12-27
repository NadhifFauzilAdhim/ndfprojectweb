<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Carbon\Carbon;

class RdapService
{
    /**
     * Lookup IP ke APNIC / IDNIC RDAP
     */
    public function lookup(string $ip): array
    {
        try {
            $response = Http::timeout(5)
                ->retry(2, 300)
                ->acceptJson()
                ->get("https://idnic.rdap.apnic.net/ip/{$ip}");

            if (!$response->ok()) {
                return [
                    'success' => false,
                    'message' => 'Data tidak ditemukan atau IP tidak valid.',
                ];
            }

            $raw = $response->json();

            if (!is_array($raw)) {
                return [
                    'success' => false,
                    'message' => 'Format data RDAP tidak valid.',
                ];
            }

            return [
                'success' => true,
                'data'    => $raw,
                'parsed'  => $this->parseRdapData($raw, $ip),
            ];

        } catch (ConnectionException $e) {
            return [
                'success' => false,
                'message' => 'Gagal terhubung ke server RDAP.',
            ];
        } catch (\Throwable $e) {
            report($e);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem.',
            ];
        }
    }

    /**
     * Parsing data RDAP agar mudah dibaca
     */
    private function parseRdapData(array $json, string $ip): array
    {
        // Entity utama
        $entity = $json['entities'][0] ?? [];
        $vcard  = $entity['vcardArray'][1] ?? [];

        $contact = [
            'name'    => 'Unknown',
            'address' => '-',
            'email'   => '-',
            'phone'   => [],
        ];

        foreach ($vcard as $item) {
            if (!isset($item[0], $item[3])) continue;

            match ($item[0]) {
                'fn'    => $contact['name'] = $item[3],
                'email' => $contact['email'] = $item[3],
                'tel'   => $contact['phone'][] = $item[3],
                'adr'   => $this->parseAddress($item, $contact),
                default => null,
            };
        }

        // Events
        $events = [];
        foreach ($json['events'] ?? [] as $event) {
            if (!isset($event['eventAction'], $event['eventDate'])) continue;

            $events[] = [
                'action' => ucwords(str_replace('_', ' ', $event['eventAction'])),
                'date'   => Carbon::parse($event['eventDate'])
                    ->format('d M Y, H:i T'),
            ];
        }

        // Remarks
        $remarks = [];
        foreach ($json['remarks'] ?? [] as $rem) {
            $remarks[] = [
                'title' => ucwords($rem['title'] ?? 'Info'),
                'desc'  => implode('<br>', $rem['description'] ?? []),
            ];
        }

        return [
            'ip'       => $json['startAddress'] ?? $ip,
            'range'    => ($json['startAddress'] ?? '-') . ' - ' . ($json['endAddress'] ?? '-'),
            'cidr'     => isset($json['cidr0_cidrs'][0])
                ? $json['cidr0_cidrs'][0]['v4prefix'] . '/' . $json['cidr0_cidrs'][0]['length']
                : '-',
            'net_name' => $json['name'] ?? 'Unknown',
            'country'  => $json['country'] ?? '-',
            'status'   => implode(', ', $json['status'] ?? []),
            'type'     => $json['type'] ?? '-',
            'contact'  => $contact,
            'events'   => $events,
            'remarks'  => $remarks,
            'handle'   => $json['handle'] ?? '-',
            'port43'   => $json['port43'] ?? '-',
        ];
    }

    /**
     * Parsing alamat RDAP
     */
    private function parseAddress(array $item, array &$contact): void
    {
        $label = $item[1]['label'] ?? null;
        $value = $item[3] ?? null;

        if ($label) {
            $contact['address'] = nl2br(e($label));
        } elseif (is_array($value)) {
            $contact['address'] = implode(', ', array_filter($value));
        }
    }
}
