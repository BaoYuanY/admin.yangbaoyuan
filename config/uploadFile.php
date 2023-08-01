<?php

return [
    'qiniuyun'   => [
        'AccessKey' => env('QINIUYUN_ACCESS_KEY', ''),
        'SecretKey' => env('QINIUYUN_SECRET_KEY', ''),
        'Bucket'    => env('QINIUYUN_BUCKET', ''),
        'CdnUrl'    => env('QINIUYUN_CDN_URL', ''),
    ],
    'tengxunyun' => [

    ],
    'aliyun'     => [
        'AccessKeyId'     => env('ALIYUN_ACCESS_KEY_ID', ''),
        'AccessKeySecret' => env('ALIYUN_ACCESS_KEY_SECRET', ''),
        'Endpoint'        => env('ALIYUN_ENDPOINT', ''),
        'Bucket'          => env('ALIYUN_BUCKET', ''),
        'CdnUrl'          => env('ALIYUN_CDN_URL', ''),
    ]
];
