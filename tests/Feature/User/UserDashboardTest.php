<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function users_can_visit_users_dashboard()
    {
        $user = factory(User::class)->create([
            'doctor' => false,
        ]);

        $this->actingAs($user)
            ->get(route('user_dashboard'))
            ->assertSee('Panel de usuario')
            ->assertStatus(200);

    }

    /** @test */
    function non_default_users_cannot_visit_users_dashboard()
    {
        $user = factory(User::class)->create([
            'doctor' => true,
        ]);

        $this->actingAs($user)
            ->get(route('user_dashboard'))
            ->assertStatus(403);

    }

    // /** @test */
    // function admins_can_visit_users_dashboard()
    // {
    //     $this->actingAsAdmin()
    //         ->get(route('home'))
    //         ->assertSee('Dashboard')
    //         ->assertStatus(200);

    // }

    /** @test */
    function it_redirects_guest_users_to_login_page()
    {
        $this->get(route('user_dashboard'))
            ->assertStatus(302)
            ->assertRedirect('login');

    }
}
