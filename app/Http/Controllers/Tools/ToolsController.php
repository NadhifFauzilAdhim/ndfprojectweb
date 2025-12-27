<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function index()
    {
        // Daftar tools bisa didefinisikan di sini agar view lebih rapi
        // dan mudah ditambah di kemudian hari.
        $tools = [

            [
                'name' => 'Link Shortener',
                'description' => 'Buat link pendek dengan kustomisasi URL, password, dan jangka waktu aktif.',
                'icon' => 'bi-link-45deg',
                'color' => '#22c55e', // Green – produktivitas
                'route' => 'link.index',
                'badge' => 'Available',
            ],
            [
                'name' => 'Location Tracker',
                'description' => 'Lacak lokasi akurat dengan link publik.',
                'icon' => 'bi-geo-alt-fill',
                'color' => '#ef4444', // Red – deprecated / warning
                'route' => 'dashboard.tracking.index',
                'badge' => 'Deprecated',
            ],
            [
                'name' => 'Network WHOIS Lookup',
                'description' => 'Cek pemilik jaringan, ASN, kontak teknis, dan informasi registrasi IP (RDAP).',
                'icon' => 'bi-diagram-3-fill',
                'color' => '#0ea5e9', // Sky Blue – network
                'route' => 'network.lookup',
                'badge' => 'Available',
            ],
            [
                'name' => 'IP Geolocation',
                'description' => 'Lacak lokasi fisik, negara, dan detail ISP dari alamat IP publik.',
                'icon' => 'bi-globe-americas',
                'color' => '#f59e0b', // Amber – geo / analysis
                'route' => 'ip.lookup',
                'badge' => 'Available',
            ],
            [
                'name' => 'Discord Lookup',
                'description' => 'Analisis mendalam profil pengguna Discord, cek tanggal pembuatan akun, status Nitro, dan unduh aset HD.',
                'icon' => 'bi-discord',
                'color' => '#5865F2', // Discord brand color
                'route' => 'discord.lookup',
                'badge' => 'Available',
            ],
            [
                'name' => 'DNS Lookup',
                'description' => 'Cek informasi DNS dari domain yang Anda inginkan.',
                'icon' => 'bi-shield-lock-fill',
                'color' => '#6366f1', // Indigo – security
                'route' => '#',
                'badge' => 'Coming Soon',
            ],
            
        
        ];

        return view('tools.index', compact('tools'));
    }
}