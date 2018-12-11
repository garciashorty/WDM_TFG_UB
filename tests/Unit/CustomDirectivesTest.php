<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Facades\Blade;

class CustomDirectivesTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    function administrator_user_can_see_the_contents_of_the_directive_admin()
    {
        $admin = factory(User::class)->create([
            'admin' => true
        ]);

        $this->actingAs($admin)
            ->assertTrue(Blade::check('admin'));
    }

    /** @test */
    function non_administrator_user_cannot_see_the_contents_of_the_directive_admin()
    {
        $user = factory(User::class)->create([
            'admin' => false
        ]);

        $this->actingAs($user)
            ->assertFalse(Blade::check('admin'));
    }
}
