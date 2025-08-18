<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{

    protected $table = 'admins';

    protected $fillable = ['name', 'email', 'password', 'is_Admin'];

    protected $hidden = ['password', 'remember_token'];
     
}
