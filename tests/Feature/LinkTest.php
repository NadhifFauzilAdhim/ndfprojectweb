<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LinkTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Uji halaman utama dapat diakses.
     */
    public function test_home_page_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Uji proses pembuatan link baru melalui method store.
     */
    public function test_store_creates_new_link(): void
    {
        // Buat user dan lakukan autentikasi
        $user = User::factory()->count(3)->create()->first();
        $this->actingAs($user);
        

        // Fake HTTP response untuk mendapatkan judul website
        Http::fake([
            'example.com' => Http::response('<html><head><title>Example Site</title></head><body></body></html>', 200),
        ]);

        $postData = [
            'target_url' => 'https://example.com',
            'slug'       => 'example-slug',
        ];

        // Pastikan route link.store sudah didefinisikan
        $response = $this->post(route('link.store'), $postData);
        $response->assertRedirect();
        $this->assertDatabaseHas('links', [
            'slug'       => 'example-slug',
            'target_url' => 'https://example.com',
            'user_id'    => $user->id,
        ]);
    }

    /**
     * Uji proses update link menggunakan quickedit.
     */
    public function test_update_modifies_link(): void
    {
        // Buat user dan autentikasi
        $user = User::factory()->count(3)->create()->first();
        $this->actingAs($user);
        
        // Buat link milik user
        $link = Link::factory()->create([
            'user_id'    => $user->id,
            'target_url' => 'https://example.com',
            'slug'       => 'initial-slug',
        ]);

        // Fake HTTP response untuk mengambil judul website baru
        Http::fake([
            'example.org' => Http::response('<html><head><title>Example Org</title></head><body></body></html>', 200),
        ]);

        $updateData = [
            'title'      => 'Example Org',
            'target_url' => 'https://example.org',
            'slug'       => 'updated-slug',
            'active'     => '1', // Misalnya datang dari checkbox
         
        ];

        // Pastikan route link.update sudah didefinisikan
        $response = $this->putJson(route('link.update', $link), $updateData);
        $response->assertJsonFragment(['success' => true]);

        $this->assertDatabaseHas('links', [
            'id'         => $link->id,
            'slug'       => 'updated-slug',
            'target_url' => 'https://example.org',
        ]);
    }

    /**
     * Uji penghapusan link melalui method destroy.
     */
    public function test_destroy_deletes_link(): void
    {
        $user = User::factory()->count(3)->create()->first();
        $this->actingAs($user);
        
        $link = Link::factory()->create([
            'user_id' => $user->id,
            'target_url' => 'https://example.com',
            'slug'       => 'example-slug',
        ]);

        // Pastikan route link.destroy sudah didefinisikan
        $response = $this->delete(route('link.destroy', $link));
        $response->assertRedirect();
        $this->assertDatabaseMissing('links', [
            'id' => $link->id,
        ]);
    }
}
