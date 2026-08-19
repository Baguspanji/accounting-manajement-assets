<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_login_page_loads_for_guest(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('Masuk ke Dashboard');
    }

    public function test_user_can_login_and_redirects_to_dashboard(): void
    {
        $user = User::firstOrFail();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_wrong_credentials_fails(): void
    {
        $this->from(route('login'))
            ->post(route('login'), [
                'email' => 'admin@admin.com',
                'password' => 'salah-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_authenticated_user_cannot_access_login(): void
    {
        $user = User::firstOrFail();

        $this->actingAs($user)->get(route('login'))->assertRedirect(route('dashboard'));
    }

    public function test_user_can_logout(): void
    {
        $user = User::firstOrFail();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_dashboard_renders_kpi_and_tables(): void
    {
        $user = User::firstOrFail();

        $this->actingAs($user)->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Total Aset')
            ->assertSee('Nilai Perolehan')
            ->assertSee('Aset per Kategori')
            ->assertSee('Jurnal Terbaru')
            ->assertSee('Aset Terbaru');
    }
}
