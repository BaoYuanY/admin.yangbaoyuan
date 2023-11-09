<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Service\web\ClipboardService;
use App\Models\web\ClipboardModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function show()
    {
        return "欢迎来到我的书屋";
    }


    public function view()
    {
        $clipboards = ClipboardModel::query()
            //->where('created_at', '>', Carbon::now()->subDays(7)->format('Y-m-d H:i:s'))
            ->get();
        return view('BaoYuan/clipboard')->with('clipboards', $clipboards);
    }


    public function delete(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        ClipboardService::delete($id);
        return $this->success();
    }

    public function addView(Request $request)
    {
        return view('BaoYuan/addClipboard');
    }

    public function add(Request $request): \Illuminate\Http\RedirectResponse
    {
        $content = $request->post('body', '');
        ClipboardService::add($content);
        return redirect()->back();
    }



}
