<?php

namespace App\Models\web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClipboardModel extends Model
{
    use HasFactory;

    protected $table = 'clipboards';

    protected $fillable = [
        'content',
    ];
}
