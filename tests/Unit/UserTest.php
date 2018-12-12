<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_cannot_be_an_admin()
    {
        $user = factory(User::class)->create([]);

        $user->refresh();

        $this->assertFalse($user->isAdmin());
    }
}
