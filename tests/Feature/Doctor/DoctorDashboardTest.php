<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class DoctorDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function doctors_can_visit_doctors_dashboard()
    {
        $user = factory(User::class)->create([
            'doctor' => true,
        ]);

        $this->actingAs($user)
            ->get(route('doctor_dashboard'))
            ->assertSee('Panel de doctor')
            ->assertStatus(200);

    }

    /** @test */
    function non_doctors_cannot_visit_doctors_dashboard()
    {
        $user = factory(User::class)->create([
            'doctor' => false,
        ]);

        $this->actingAs($user)
            ->get(route('doctor_dashboard'))
            ->assertStatus(403);

    }

    // /** @test */
    // function it_shows_users_dashboards_to_admins()
    // {
    //     $this->actingAsAdmin()
    //         ->get(route('home'))
    //         ->assertSee('Dashboard')
    //         ->assertStatus(200);

    // }

    /** @test */
    function it_redirects_guest_users_to_login_page()
    {
        $this->get(route('doctor_dashboard'))
            ->assertStatus(302)
            ->assertRedirect('login');

    }
}
