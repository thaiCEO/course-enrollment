<?php

namespace App\Models;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{

    use HasRoles;

    protected $table = 'admins';

    protected $fillable = ['name', 'email', 'password', 'is_Admin'];

    protected $hidden = ['password', 'remember_token'];
     
        // 👈 set the guard to match your auth.php
    protected $guard_name = 'web';
}
