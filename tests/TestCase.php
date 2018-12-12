<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Admin;
use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function actingAsAdmin($admin = null)
    {
        if ($admin == null) {
            $admin = $this->createAdmin();
        }

        return $this->actingAs($admin, 'admin');
    }

    protected function actingAsUser($user = null)
    {
        if ($user == null) {
            $user = $this->createUser();
        }

        return $this->actingAs($user);
    }

    protected function actingAsDoctor($doctor = null)
    {
        if ($doctor == null) {
            $doctor = $this->createDoctor();
        }

        return $this->actingAs($doctor);
    }

    protected function createAdmin(array $attributes = [])
    {
        return factory(Admin::class)->create($attributes);
    }

    protected function createUser(array $attributes = ['doctor' => false])
    {
        $user = factory(User::class)->create($attributes);

        //dd($user);

        return $user;
    }

    protected function createDoctor(array $attributes = ['doctor' => true])
    {
        $doctor = factory(User::class)->create($attributes);

        //dd($doctor);

        return $doctor;
    }
}
