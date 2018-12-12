<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Admin;
use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createAdmin()
    {
        return factory(Admin::class)->create([
            'admin' => true,
        ]);
    }

    protected function createUser()
    {
        return factory(User::class)->create([
            'doctor' => false,
            'admin' => false,
        ]);
    }

    protected function createDoctor()
    {
        return factory(User::class)->create([
            'doctor' => true,
            'admin' => false,
        ]);
    }
}
