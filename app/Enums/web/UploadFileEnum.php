<?php

namespace App\Enums\web;

class UploadFileEnum
{
    const UPLOAD_FILE_TYPE_LOCAL     = 0;
    const UPLOAD_FILE_TYPE_QINIUYUN  = 1;
    const UPLOAD_FILE_TYPE_TENXUNYUN = 2;
    const UPLOAD_FILE_TYPE_ALIYUN    = 3;

    const UPLOAD_FILE_MAPPING = [
        self::UPLOAD_FILE_TYPE_LOCAL     => '本地',
        self::UPLOAD_FILE_TYPE_QINIUYUN  => '七牛云',
        self::UPLOAD_FILE_TYPE_TENXUNYUN => '腾讯云',
        self::UPLOAD_FILE_TYPE_ALIYUN    => '阿里云',
    ];

}
