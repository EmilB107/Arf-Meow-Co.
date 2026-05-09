<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_signup_page_loads(): void
    {
        $this->get('/signup')->assertStatus(200);
    }

    public function test_register_with_valid_data_creates_user(): void
    {
        $this->post('/signup', [
            'name'                  => 'Jane Doe',
            'email'                 => 'jane@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'jane@example.com', 'name' => 'Jane Doe']);
    }

    public function test_register_with_valid_data_logs_user_in(): void
    {
        $this->post('/signup', [
            'name'                  => 'Jane Doe',
            'email'                 => 'jane@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertAuthenticated();
    }

    public function test_register_redirects_to_dashboard(): void
    {
        $this->post('/signup', [
            'name'                  => 'Jane Doe',
            'email'                 => 'jane@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect('/dashboard');
    }

    public function test_register_with_duplicate_email_fails(): void
    {
        $role = Role::create(['name' => 'Admin']);
        User::factory()->create(['email' => 'taken@example.com', 'role_id' => $role->id]);

        $this->post('/signup', [
            'name'                  => 'Another Person',
            'email'                 => 'taken@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_register_with_password_under_8_chars_fails(): void
    {
        $this->post('/signup', [
            'name'                  => 'Bob',
            'email'                 => 'bob@example.com',
            'password'              => 'short',
            'password_confirmation' => 'short',
        ])->assertSessionHasErrors('password');

        $this->assertGuest();
    }

    public function test_register_with_mismatched_passwords_fails(): void
    {
        $this->post('/signup', [
            'name'                  => 'Alice',
            'email'                 => 'alice@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'different123',
        ])->assertSessionHasErrors('password');

        $this->assertGuest();
    }

    public function test_register_requires_name(): void
    {
        $this->post('/signup', [
            'name'                  => '',
            'email'                 => 'someone@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ])->assertSessionHasErrors('name');
    }

    public function test_register_requires_valid_email_format(): void
    {
        $this->post('/signup', [
            'name'                  => 'Test',
            'email'                 => 'not-an-email',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ])->assertSessionHasErrors('email');
    }
}
