<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    public function isAdmin()
    {
        return $this->admin;
    }
}
