<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $regularStaff;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'username' => 'admin',
            'full_name' => 'Test Administrator',
            'password' => 'AdminTestPassword123!',
            'created_at' => now(),
        ]);

        $this->regularStaff = User::create([
            'username' => 'teststaff',
            'full_name' => 'Regular Test Staff',
            'password' => 'StaffTestPassword123!',
            'created_at' => now(),
        ]);
    }

    public function test_administrator_can_access_staff_management(): void
    {
        $this->actingAs($this->admin)
            ->get(route('staff.index'))
            ->assertOk();
    }

    public function test_regular_staff_cannot_access_staff_management(): void
    {
        $this->actingAs($this->regularStaff)
            ->get(route('staff.index'))
            ->assertForbidden();
    }

    public function test_regular_staff_cannot_create_staff_accounts(): void
    {
        $this->actingAs($this->regularStaff)
            ->post(route('staff.store'), [
                'username' => 'unauthorized',
                'full_name' => 'Unauthorized Staff',
                'password' => 'Password123!',
                'password_confirmation' => 'Password123!',
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('users', [
            'username' => 'unauthorized',
        ]);
    }

    public function test_regular_staff_cannot_update_staff_accounts(): void
    {
        $this->actingAs($this->regularStaff)
            ->put(route('staff.update', $this->admin), [
                'username' => 'admin',
                'full_name' => 'Changed Administrator',
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
            'full_name' => 'Test Administrator',
        ]);
    }

    public function test_regular_staff_cannot_delete_staff_accounts(): void
    {
        $this->actingAs($this->regularStaff)
            ->delete(route('staff.destroy', $this->admin))
            ->assertForbidden();

        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
        ]);
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get(route('staff.index'))
            ->assertRedirect(route('login'));
    }

    public function test_regular_staff_cannot_see_staff_management_button(): void
    {
        $this->actingAs($this->regularStaff)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertDontSee('Manage Staff')
            ->assertDontSee('href="' . route('staff.index') . '"', false);
    }

    public function test_administrator_can_see_staff_management_button(): void
    {
        $this->actingAs($this->admin)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Manage Staff');
    }
}
