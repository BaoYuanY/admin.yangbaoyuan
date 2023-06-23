<?php

namespace App\Http\Controllers\web;


use App\Http\Controllers\Controller;
use App\Http\Service\web\PasswordService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    public function index(Request $request)
    {
        return view('BaoYuan/password');
    }


    /**
     * @throws ValidationException
     */
    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validate($request, [
            'platform' => 'required|string',
            'account'  => 'required|string',
            'salt'     => 'required|string',
        ]);

        return $this->success(PasswordService::search($request->platform, $request->account, $request->salt));
    }


}
