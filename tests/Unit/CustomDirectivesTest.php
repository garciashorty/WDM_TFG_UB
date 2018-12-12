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
        $this->actingAs($this->createAdmin())
            ->assertTrue(Blade::check('admin'));
    }

    /** @test */
    function non_administrator_user_cannot_see_the_contents_of_the_directive_admin()
    {
        $this->actingAs($this->createUser())
            ->assertFalse(Blade::check('admin'));

        $this->actingAs($this->createDoctor())
            ->assertFalse(Blade::check('admin'));
    }
}
