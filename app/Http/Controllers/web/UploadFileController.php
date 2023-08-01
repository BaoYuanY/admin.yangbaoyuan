<?php

namespace App\Http\Controllers\web;

use App\Enums\web\UploadFileEnum;
use App\Http\Controllers\Controller;
use App\Http\Service\web\UploadFileService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class UploadFileController extends Controller
{
    public function view()
    {
        return view('BaoYuan/uploadFile')->with(['select' => UploadFileEnum::UPLOAD_FILE_MAPPING]);
    }

    /**
     * @throws Exception
     */
    public function upload(Request $request)
    {
        ini_set('memory_limit','2048M');
        $file = $request->file('file');
        $name = $request->post('name');
        $type = $request->post('type', 0);
        if (!$file instanceof UploadedFile) {
            return '没有上传文件';
        }

        $fileExtension = $file->getClientOriginalExtension();

        if (!mb_strlen($name)) {
            $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        }

        UploadFileService::uploadFile($file->getRealPath(), $fileExtension, $name, $type);

        return redirect()->back();
    }
}
