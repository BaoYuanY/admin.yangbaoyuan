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
                    'phone'    => encryptPhone($usePassword->phone),
                    'password' => deAes128Ecb($usePassword->password, $usePassword->platform)
                ];
            })->values()->toArray();
    }

    public static function add(array $params): bool
    {
        $field = [
            'platform',
            'phone',
            'account',
            'email',
            'password',
            'salt',
        ];

        $params['password'] = enAes128Ecb($params['password'], $params['platform']);

        $insertData = array_filter($params, function ($key) use ($field) {
            return in_array($key, $field);
        }, ARRAY_FILTER_USE_KEY);
        return UsePasswordAllModel::query()->insert(array_filter($insertData));
    }

}
