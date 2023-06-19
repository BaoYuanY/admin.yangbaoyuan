<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsePasswordAllModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'phone',
        'email',
        'password',
        'salt',
    ];


}
