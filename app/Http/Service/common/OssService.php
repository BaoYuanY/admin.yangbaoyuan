<?php

namespace App\Http\Service\common;

use Exception;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class OssService
{
    /**
     * @throws Exception
     */
    public static function qiniuyunOss($filePath, $fileName): string
    {
        // 七牛云账户AccessKey， SecretKey
        $accessKey = config('uploadFile.qiniuyun.AccessKey');
        $secretKey = config('uploadFile.qiniuyun.SecretKey');
        $bucket    = config('uploadFile.qiniuyun.Bucket');
        $url       = config('uploadFile.qiniuyun.CdnUrl');

        $auth = new Auth($accessKey, $secretKey);
        //鉴权
        $token = $auth->uploadToken($bucket);

        $uploadMgr = new UploadManager();

        list($ret, $err) = $uploadMgr->putFile($token, $fileName, $filePath);

        if ($err !== null) {
            return '';
        }
        return $url . $ret['key'];
    }


}
