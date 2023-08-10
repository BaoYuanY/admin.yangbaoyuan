<?php

namespace App\Http\Service\web;

use App\Models\web\ClipboardModel;

class ClipboardService
{
    public static function delete($id)
    {
        return ClipboardModel::query()->where('id', $id)->delete();
    }

    public static function add(string $content): bool
    {
        $clipboardModel = new ClipboardModel();
        $clipboardModel->content = $content;
        return $clipboardModel->save();
    }
}
