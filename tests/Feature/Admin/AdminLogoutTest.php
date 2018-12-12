<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminLogoutTest extends TestCase
{
    /** @test */
    public function an_admin_can_logout()
    {
        auth('admin')->login($this->createAdmin());

        $this->assertAuthenticated('admin');

        $response = $this->post('admin/logout');

        $response->assertRedirect('/');

        $this->assertGuest('admin');
    }

    /** @test */
    public function logging_out_as_an_admin_does_not_terminate_the_user_session()
    {
        auth('admin')->login($this->createAdmin());
        auth('web')->login($this->createUser());

        $adminSessionName = auth('admin')->getName();
        $userSessionName = auth('web')->getName();

        $this->assertAuthenticated('admin');
        $this->assertAuthenticated('web');

        $response = $this->post('admin/logout');

        $response->assertRedirect('/')
            ->assertSessionHas($userSessionName)
            ->assertSessionMissing($adminSessionName);

        $this->assertGuest('admin');

        $this->assertAuthenticated('web');
    }
}

