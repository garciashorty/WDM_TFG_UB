<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function admins_can_visit_the_admin_dashboard()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->createAdmin())
            ->get(route('admin_dashboard'))
            ->assertStatus(200)
            ->assertSee('Panel de administrador');
    }

    /**
     * @test
     */
    public function non_admin_users_cannot_visit_the_admin_dashboard()
    {
        $this->actingAs($this->createUser())
            ->get(route('admin_dashboard'))
            ->assertStatus(403);

        $this->actingAs($this->createDoctor())
            ->get(route('admin_dashboard'))
            ->assertStatus(403);
    }



    /**
     * @test
     */
    public function guest_cannot_visit_the_admin_dashboard()
    {
        $this->get(route('admin_dashboard'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }
}
