<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for route access control.
 *
 * Authenticated access tests will pass as-is.
 * Guest redirect tests (marked below) will FAIL until auth middleware
 * is added to the protected routes — they document the intended behavior.
 */
class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(string $roleName): User
    {
        $role = Role::create(['name' => $roleName]);
        return User::factory()->create(['role_id' => $role->id]);
    }

    // --- Authenticated users can access their routes ---

    public function test_admin_can_reach_dashboard(): void
    {
        $this->actingAs($this->makeUser('Admin'))
             ->get('/dashboard')
             ->assertStatus(200);
    }

    public function test_project_manager_can_reach_dashboard(): void
    {
        $this->actingAs($this->makeUser('Project Manager'))
             ->get('/dashboard')
             ->assertStatus(200);
    }

    public function test_admin_can_reach_products_index(): void
    {
        $this->actingAs($this->makeUser('Admin'))
             ->get('/products')
             ->assertStatus(200);
    }

    public function test_super_admin_can_reach_superadmin_dashboard(): void
    {
        $this->actingAs($this->makeUser('Super Admin'))
             ->get('/superadmin')
             ->assertStatus(200);
    }

    public function test_home_page_is_publicly_accessible(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_login_page_is_publicly_accessible(): void
    {
        $this->get('/login')->assertStatus(200);
    }

    public function test_signup_page_is_publicly_accessible(): void
    {
        $this->get('/signup')->assertStatus(200);
    }

    // --- Guest redirect tests (require auth middleware on routes to pass) ---

    public function test_guest_is_redirected_from_dashboard_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_guest_is_redirected_from_products_to_login(): void
    {
        $this->get('/products')->assertRedirect('/login');
    }

    public function test_guest_is_redirected_from_superadmin_to_login(): void
    {
        $this->get('/superadmin')->assertRedirect('/login');
    }

    public function test_guest_cannot_access_product_create(): void
    {
        $this->get('/products/create')->assertRedirect('/login');
    }

    public function test_guest_cannot_post_to_products(): void
    {
        $this->post('/products', [])->assertRedirect('/login');
    }
}
