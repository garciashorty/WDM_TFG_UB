<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_shows_home_to_authenticated_users()
    {
        $user = factory(User::class)->create([]);

        $this->actingAs($user)
            ->get(route('default_user.home'))
            ->assertSee('Panel de usuario')
            ->assertStatus(200);

    }

    // /** @test */
    // function it_shows_home_to_admins()
    // {
    //     $this->actingAsAdmin()
    //         ->get(route('home'))
    //         ->assertSee('Dashboard')
    //         ->assertStatus(200);

    // }

    /** @test */
    function it_redirects_guest_users_to_login_page()
    {
        $this->get(route('default_user.home'))
            ->assertStatus(302)
            ->assertRedirect('login');

    }
}
