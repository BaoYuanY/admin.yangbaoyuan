<?php

namespace App\Http\Service\web;

use App\Enums\web\UploadFileEnum;
use App\Http\Service\common\OssService;
use Exception;

class UploadFileService
{
    /**
     * @throws Exception
     */
    public static function uploadFile(string $filePath, string $suffix, string $fileName, string $type)
    {
        $fileUrl = '';
        switch ($type) {
            case UploadFileEnum::UPLOAD_FILE_TYPE_QINIUYUN:
                $fileUrl = OssService::qiniuyunOss($filePath, $fileName . '.' . $suffix);
                break;
            case UploadFileEnum::UPLOAD_FILE_TYPE_TENXUNYUN:

                break;
            case UploadFileEnum::UPLOAD_FILE_TYPE_ALIYUN:

                break;
            default:
                //上传到本地



        }




        @unlink($filePath);
        return (bool)mb_strlen($fileUrl);
    }





}
