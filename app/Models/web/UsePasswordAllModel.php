<?php

namespace App\Models\web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsePasswordAllModel extends Model
{
    use HasFactory;

    protected $table = 'use_password_all';

    protected $fillable = [
        'platform',
        'phone',
        'account',
        'email',
        'password',
        'salt',
    ];


}
