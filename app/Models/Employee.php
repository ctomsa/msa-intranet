<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'full_name',
        'position',
        'department',
        'email',
        'phone_internal',
        'phone_mobile',
        'responsibilities',
        'avatar_path',
    ];
}