<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Services\ApiServices;

class DiscordUserController extends Controller
{

    /**
     * Handle Page Request (Search & Display)
     */
    public function index(Request $request, ApiServices $apiServices)
    {
        $userData = null;
        $error = null;

        // Cek apakah ada input 'user_id' dari form
        if ($request->filled('user_id')) {
            try {
                $raw = $apiServices->fetchDiscordUser($request->user_id);

                if (!$raw) {
                    $error = 'User tidak ditemukan atau ID salah.';
                } else {
                    $userData = $this->processUserData($raw);
                }

            } catch (\Exception $e) {
                $error = 'Terjadi kesalahan server: ' . $e->getMessage();
            }
        }
        
        // Kembalikan ke View dengan membawa data (jika ada)
        return view('tools.discord.index', compact('userData', 'error'));
    }


    private function processUserData($userData)
    {
        $id = $userData['id'];
        $flagsRaw = $userData['flags'] ?? 0;
        
        // Avatar logic
        $avatarUrl = isset($userData['avatar'])
            ? $this->getImageUrl('avatar', $id, $userData['avatar'])
            : 'https://cdn.discordapp.com/embed/avatars/index.png';

        // Banner logic
        $bannerUrl = isset($userData['banner'])
            ? $this->getImageUrl('banner', $id, $userData['banner'])
            : null;

        // Decoration logic
        $decorationUrl = null;
        if (isset($userData['avatar_decoration'])) {
            $decorationUrl = "https://cdn.discordapp.com/avatar-decorations/{$id}/{$userData['avatar_decoration']}.png";
        } elseif (isset($userData['avatar_decoration_data'])) {
            $asset = $userData['avatar_decoration_data']['asset'];
            $decorationUrl = "https://cdn.discordapp.com/avatar-decoration-presets/{$asset}.png?4096";
        }

        return [
            'id' => $id,
            'global_name' => $userData['global_name'] ?? null,
            'username' => $userData['username'],
            'discriminator' => $userData['discriminator'],
            'avatar' => $avatarUrl,
            'avatarDecoration' => $decorationUrl,
            'banner' => $bannerUrl,
            'accentColor' => $userData['accent_color'] ?? null,
            'bannerColor' => $userData['banner_color'] ?? null,
            'isBot' => $userData['bot'] ?? false,
            'flags' => $this->resolveUserFlags($flagsRaw),
            'nitroType' => $this->resolveNitroType($userData['premium_type'] ?? 0),
            'creationDate' => $this->getCreationDate($id)->format('d M Y, H:i'),
        ];
    }

    private function getImageUrl($type, $id, $hash)
    {
        $baseUrl = ($type === 'avatar') ? 'https://cdn.discordapp.com/avatars' : 'https://cdn.discordapp.com/banners';
        $isGif = str_starts_with($hash, 'a_');
        $ext = $isGif ? 'gif' : 'png';
        return "{$baseUrl}/{$id}/{$hash}.{$ext}";
    }

    private function getCreationDate($snowflake)
    {
        return Carbon::createFromTimestampMs(($snowflake / 4194304) + 1420070400000);
    }

    private function resolveNitroType($type)
    {
        $types = [
            0 => ['value' => 0, 'icon' => null],
            1 => ['value' => 1, 'icon' => "https://cdn.discordapp.com/badge-icons/2ba85e8026a8614b640c2837bcdfe21b.png"],
            2 => ['value' => 2, 'icon' => "https://cdn.discordapp.com/badge-icons/2ba85e8026a8614b640c2837bcdfe21b.png"],
            3 => ['value' => 3, 'icon' => "https://cdn.discordapp.com/badge-icons/2ba85e8026a8614b640c2837bcdfe21b.png"],
        ];
        return $types[$type] ?? ['value' => 0, 'icon' => null];
    }

    private function resolveUserFlags($flags)
    {
        $config = $this->getDefaultFlagsConfig();
        $userFlags = [];
        foreach ($config as $bit => $data) {
            if ($flags & $bit) $userFlags[] = $data;
        }
        return $userFlags;
    }

    private function getDefaultFlagsConfig()
    {
        // ... (Gunakan config flags yang sama seperti sebelumnya)
        return [
            1 => ['name' => "STAFF", 'icon' => "https://cdn.discordapp.com/badge-icons/5e74e9b61934fc1f67c65515d1f7e60d.png"],
            // ... copy paste sisa flags dari kode sebelumnya agar ringkas
            4194304 => ['name' => "ACTIVE_DEVELOPER", 'icon' => "https://cdn.discordapp.com/badge-icons/6bdc42827a38498929a4920da12695d9.png"],
        ];
    }
}