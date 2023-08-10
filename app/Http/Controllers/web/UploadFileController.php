<?php

namespace App\Http\Controllers\web;

use App\Enums\web\UploadFileEnum;
use App\Http\Controllers\Controller;
use App\Http\Service\web\UploadFileService;
use App\Models\web\UploadFIleRecordModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use function Clue\StreamFilter\fun;

class UploadFileController extends Controller
{
    public function view()
    {
        $files = UploadFIleRecordModel::query()
            ->where('created_at', '>', Carbon::now()->subDay()->format('Y-m-d H:i:s'))
            ->get()
            ->map(function (UploadFIleRecordModel $model) {
                $model->platformText = UploadFileEnum::UPLOAD_FILE_MAPPING[$model->type];
                return $model;
            });

        return view('BaoYuan/uploadFile')->with(['select' => UploadFileEnum::UPLOAD_FILE_MAPPING, 'files' => $files]);
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
