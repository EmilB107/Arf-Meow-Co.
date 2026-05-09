<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleRedirectTest extends TestCase
{
    use RefreshDatabase;

    private function loginAs(string $roleName): \Illuminate\Testing\TestResponse
    {
        $role = Role::create(['name' => $roleName]);
        $user = User::factory()->create(['role_id' => $role->id]);

        return $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);
    }

    public function test_super_admin_is_redirected_to_superadmin_dashboard(): void
    {
        $this->loginAs('Super Admin')->assertRedirect('/superadmin');
    }

    public function test_admin_is_redirected_to_dashboard(): void
    {
        $this->loginAs('Admin')->assertRedirect('/dashboard');
    }

    public function test_project_manager_is_redirected_to_dashboard(): void
    {
        $this->loginAs('Project Manager')->assertRedirect('/dashboard');
    }

    public function test_user_with_no_role_is_redirected_to_dashboard(): void
    {
        $user = User::factory()->create(['role_id' => null]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ])->assertRedirect('/dashboard');
    }
}
