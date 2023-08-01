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
    public static function uploadFile(string $filePath, string $suffix, string $fileName, string $type): array
    {
        $fileName = $fileName . '.' . $suffix;
        switch ($type) {
            case UploadFileEnum::UPLOAD_FILE_TYPE_QINIUYUN:
                $fileUrl = OssService::qiniuyunOss($filePath, $fileName);
                break;
            case UploadFileEnum::UPLOAD_FILE_TYPE_ALIYUN:
                $fileUrl = OssService::aliyunOss($filePath, $fileName);
                break;
            default:
                $fileUrl = '';
        }
        @unlink($filePath);
        return ['fileUrl' => $fileUrl];
    }





}
