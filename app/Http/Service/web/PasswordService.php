<?php

namespace App\Http\Service\web;

use App\Models\web\UsePasswordAllModel;
use function Clue\StreamFilter\fun;

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
                    'platform'        => $usePassword->platform,
                    'account'         => $usePassword->account,
                    'email'           => $usePassword->email ?: '-',
                    'salt'            => $usePassword->salt ?: '-',
                    'phone'           => $usePassword->phone ? encryptPhone($usePassword->phone) : '-',
                    'encryptPassword' => 'success',
                    'copy'            => deAes128Ecb($usePassword->password, $usePassword->platform),
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

    public static function getPlatforms(): array
    {
        $list = [];
        UsePasswordAllModel::query()
            ->chunkById(10, function ($usePasswords) use (&$list) {
                foreach ($usePasswords as $usePassword) {
                    $list[$usePassword->platform] = [
                        'id'   => $usePassword->platform,
                        'name' => $usePassword->platform
                    ];
                }
            });

        return array_values($list);
    }

}
