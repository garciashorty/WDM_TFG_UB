<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function logging_in_as_an_admin()
    {
        $email = 'admin@admin.com';
        $password = '123456';

        $admin = $this->createAdmin([
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        $this->post('admin/login', compact('email', 'password'))
            ->assertRedirect('admin');

        $this->assertAuthenticatedAs($admin, 'admin');
    }

    /** @test */
    public function cannot_login_with_invalid_credentials()
    {
        $email = 'admin@admin.com';
        $password = '123456';

        $this->post('admin/login', ['email' => $email, 'password' => 'prueba'])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'email' => 'These credentials do not match our records.'
            ]);

        $this->assertGuest();
    }

    /** @test */
    public function cannot_login_with_user_credentials()
    {
        $email = 'admin2@admin.com';
        $password = '123456';

        $user = $this->createUser([
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        $this->post('admin/login', compact('email', 'password'))
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'email' => 'These credentials do not match our records.'
            ]);

        $this->assertGuest();
    }
}
