<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class HideAdminRoutesTest extends TestCase
{
    /** @test */
    public function it_does_not_allow_guests_to_discover_admin_urls()
    {
        $this->get('admin/invalid-url')
            ->assertStatus(302)
            ->assertRedirect('login');
    }

    /** @test */
    public function it_does_not_allow_guests_to_discover_admin_urls_post()
    {
        $this->post('admin/invalid-url')
            ->assertStatus(302)
            ->assertRedirect('login');
    }

    /** @test */
    public function it_displays_404s_when_admins_visit_invalid_urls()
    {
        $this->actingAsAdmin()
            ->get('admin/invalid-url')
            ->assertStatus(404);
    }
}
