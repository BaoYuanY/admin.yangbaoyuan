<?php

namespace App\Http\Service\web;

use App\Enums\web\UploadFileEnum;
use App\Http\Service\common\OssService;
use App\Models\web\UploadFIleRecordModel;
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
        //日志记录

        $uploadFileRecordModel       = new UploadFIleRecordModel();
        $uploadFileRecordModel->url  = $fileUrl;
        $uploadFileRecordModel->type = $type;
        $uploadFileRecordModel->save();


        return ['fileUrl' => $fileUrl];
    }


}
