<?php

namespace App\Http\Service\common;

use Exception;
use OSS\Core\OssException;
use OSS\OssClient as AliyunOssClient;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class OssService
{
    /**
     * 七牛云文件上传
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


    /**
     * 阿里云文件上传
     * @param string $filePath
     * @param string $fileName
     * @return string
     */
    public static function aliyunOss(string $filePath, string $fileName): string
    {
        $accessKeyId     = config('uploadFile.aliyun.AccessKeyId');
        $accessKeySecret = config('uploadFile.aliyun.AccessKeySecret');
        // yourEndpoint填写Bucket所在地域对应的Endpoint。以华东1（杭州）为例，Endpoint填写为https://oss-cn-hangzhou.aliyuncs.com。
        $endpoint = "https://oss-cn-" . config('uploadFile.aliyun.Endpoint') . ".aliyuncs.com";
        // 填写Bucket名称，例如examplebucket。
        $bucket = config('uploadFile.aliyun.Bucket');
        // 填写Object完整路径，例如exampledir/exampleobject.txt。Object完整路径中不能包含Bucket名称。
        //$object = $fileName;
        // <yourLocalFile>由本地文件路径加文件名包括后缀组成，例如/users/local/myfile.txt。
        // 填写本地文件的完整路径，例如D:\\localpath\\examplefile.txt。如果未指定本地路径，则默认从示例程序所属项目对应本地路径中上传文件。
        $url = config('uploadFile.aliyun.CdnUrl');
        try {
            $ossClient = new AliyunOssClient($accessKeyId, $accessKeySecret, $endpoint);
            $ossClient->uploadFile($bucket, $fileName, $filePath);
            return $url . $fileName;
        } catch (OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return '';
        }
    }



}
