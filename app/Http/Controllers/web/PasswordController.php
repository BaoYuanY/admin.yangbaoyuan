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

    public function indexAdd(Request $request)
    {
        return view('BaoYuan/addPassword');
    }


    /**
     * @throws ValidationException
     */
    public function search(Request $request)
    {
        $this->validate($request, [
            'platform' => 'required|string',
            'salt'     => 'required|string',
        ]);

        $platform = $request->post('platform', '');
        $account  = $request->post('account', '');
        $salt     = $request->post('salt', '');
        return $this->success(PasswordService::search($platform, $account ?: '', $salt));
    }


    /**
     * @throws ValidationException
     */
    public function add(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validate($request, [
            'platform' => 'required|string',
            'account'  => 'required|string',
            'password' => 'required|string',
        ]);
        PasswordService::add($request->all());
        return $this->success();
    }


    /**
     * @throws ValidationException
     */
    public function getPlatforms(): \Illuminate\Http\JsonResponse
    {
        return $this->success(PasswordService::getPlatforms());
    }


}
