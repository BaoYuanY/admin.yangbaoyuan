<?php

namespace App\Models\web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadFIleRecordModel extends Model
{
    use HasFactory;

    protected $table = 'upload_file_record';

    protected $fillable = [
        'type',
        'url',
        'isDeleted',
    ];


}
