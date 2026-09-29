<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAndProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
    }

    public function test_guest_cannot_access_dashboards()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');

        $response = $this->get('/kasir/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_admin_dashboard_and_products()
    {
        $admin = User::where('email', 'admin@minimarket.test')->first();

        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertStatus(200)
            ->assertSee('Dashboard Admin');

        $this->actingAs($admin)
            ->get('/products')
            ->assertStatus(200)
            ->assertSee('Data Product');

        // Admin forbidden on kasir dashboard
        $this->actingAs($admin)
            ->get('/kasir/dashboard')
            ->assertStatus(403);
    }

    public function test_kasir_can_access_kasir_dashboard_but_forbidden_on_admin_and_products()
    {
        $kasir = User::where('email', 'kasir@minimarket.test')->first();

        $this->actingAs($kasir)
            ->get('/kasir/dashboard')
            ->assertStatus(200)
            ->assertSee('Dashboard Kasir');

        $this->actingAs($kasir)
            ->get('/admin/dashboard')
            ->assertStatus(403);

        $this->actingAs($kasir)
            ->get('/products')
            ->assertStatus(403);
    }

    public function test_login_redirect_by_role()
    {
        $response = $this->post('/login', [
            'email' => 'admin@minimarket.test',
            'password' => 'password',
        ]);
        $response->assertRedirect(route('admin.dashboard'));

        $this->post('/logout');

        $response = $this->post('/login', [
            'email' => 'kasir@minimarket.test',
            'password' => 'password',
        ]);
        $response->assertRedirect(route('kasir.dashboard'));
    }

    public function test_admin_can_crud_product()
    {
        $admin = User::where('email', 'admin@minimarket.test')->first();

        // CREATE
        $response = $this->actingAs($admin)->post('/products', [
            'name' => 'Kopi Robusta Test',
            'category' => 'Minuman',
            'description' => 'Kopi robusta nikmat',
            'price' => 15000,
            'stock' => 20,
            'is_active' => '1',
        ]);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', [
            'name' => 'Kopi Robusta Test',
            'category' => 'Minuman',
        ]);

        $product = Product::where('name', 'Kopi Robusta Test')->first();

        // SHOW
        $this->actingAs($admin)
            ->get("/products/{$product->id}")
            ->assertStatus(200)
            ->assertSee('Kopi Robusta Test');

        // UPDATE
        $this->actingAs($admin)
            ->put("/products/{$product->id}", [
                'name' => 'Kopi Robusta Test Updated',
                'category' => 'Minuman Hangat',
                'description' => 'Deskripsi baru',
                'price' => 18000,
                'stock' => 15,
                'is_active' => '1',
            ])
            ->assertRedirect('/products');

        $this->assertDatabaseHas('products', [
            'name' => 'Kopi Robusta Test Updated',
            'price' => 18000,
        ]);

        // DELETE
        $this->actingAs($admin)
            ->delete("/products/{$product->id}")
            ->assertRedirect('/products');

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
