<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        $admin = User::create([
            'name' => 'Nadhif Fauzil Adhim',
            'username' => 'nadhif_f.a',
            'email' => 'nadya15a3@gmail.com',
            'is_admin' => 1,
            'email_verified_at' => now(),
            'password' => Hash::make('Nadhif2003'),
            'remember_token' => Str::random(10)

        ]);

        $user1 = User::create([
            'name' => 'Nadhif Fauzil Adhim 2',
            'username' => 'nadhif_f.aa',
            'email' => 'testing@gmail.com',
            'is_admin' => 1,
            'email_verified_at' => now(),
            'password' => Hash::make('Nadhif2003'),
            'remember_token' => Str::random(10)
        ]);

        Post::factory(2000)->recycle([
            Category::factory(5)->create(),
            $admin,
            $user1,
            User::factory(2)->create()
        ])->create();

    }
}
