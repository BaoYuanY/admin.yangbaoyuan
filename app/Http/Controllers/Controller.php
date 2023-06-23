<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function json(array $data = []): \Illuminate\Http\JsonResponse
    {
        return response()->json($data)->header('Content-Type', 'application/json;charset=utf-8');
    }

    public function success(array $data = null): \Illuminate\Http\JsonResponse
    {
        return $this->json(['code' => 200, 'msg' => '', 'data' => $data ?: null]);
    }

    public function fail(int $code, string $msg = '', array $data = null): \Illuminate\Http\JsonResponse
    {
        return $this->json(['code' => $code, 'msg' => $msg, 'data' => $data ?: null]);
    }

}
