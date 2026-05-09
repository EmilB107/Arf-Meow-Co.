<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private Role $role;

    protected function setUp(): void
    {
        parent::setUp();
        $this->role = Role::create(['name' => 'Admin']);
    }

    public function test_login_page_loads(): void
    {
        $this->get('/login')->assertStatus(200);
    }

    public function test_login_with_valid_credentials_authenticates_user(): void
    {
        $user = User::factory()->create(['role_id' => $this->role->id]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_wrong_password_is_rejected(): void
    {
        $user = User::factory()->create(['role_id' => $this->role->id]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_login_with_wrong_password_returns_email_error(): void
    {
        $user = User::factory()->create(['role_id' => $this->role->id]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');
    }

    public function test_login_with_nonexistent_email_is_rejected(): void
    {
        $this->post('/login', [
            'email'    => 'nobody@example.com',
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_requires_email(): void
    {
        $this->post('/login', [
            'email'    => '',
            'password' => 'password',
        ])->assertSessionHasErrors('email');
    }

    public function test_login_requires_password(): void
    {
        $user = User::factory()->create(['role_id' => $this->role->id]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => '',
        ])->assertSessionHasErrors('password');
    }

    public function test_login_rejects_invalid_email_format(): void
    {
        $this->post('/login', [
            'email'    => 'not-an-email',
            'password' => 'password',
        ])->assertSessionHasErrors('email');
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create(['role_id' => $this->role->id]);

        $this->actingAs($user)
             ->post('/logout')
             ->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_logout_is_not_accessible_via_get(): void
    {
        $this->get('/logout')->assertStatus(405);
    }
}
