<?php

namespace App\Http\Service\web;

use App\Models\web\UsePasswordAllModel;

class PasswordService
{
    public static function search(string $platform, string $account, string $salt): array
    {
        if (!checkT($salt)) {
            return [];
        }

        return UsePasswordAllModel::query()
            ->where('platform', 'like', "%{$platform}%")
            ->where(function ($query) use ($account) {
                $query->where('account', 'like', "%{$account}%")
                    ->orWhere('email', 'like', "%{$account}%")
                    ->orWhere('phone', 'like', "%{$account}%");
            })
            ->get()
            ->map(function ($usePassword) {
                return [
                    'platform' => $usePassword->platform,
                    'account'  => $usePassword->account,
                    'email'    => $usePassword->email,
                    'phone'    => $usePassword->phone,
                ];
            })->values()->toArray();
    }

}
