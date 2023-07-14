<?php

if (! function_exists('checkT')) {
    function checkT(string $string): bool
    {
        $currentTime = time(); // 当前时间戳
        if (preg_match('/^\d{10}$/', $string)) {
            // 第一个条件：检查输入是否为时间戳
            $inputTimestamp = (int)$string;
            $difference = abs($inputTimestamp - $currentTime);

            return $difference <= 10;
        } elseif (preg_match('/^(\d{2})$/', $string, $matches)) {
            // 第二个条件：检查输入是否为时间格式（精确到分钟）
            list(, $minute) = $matches;

            return $minute == date('i');
        }

        return false;
    }
}


if (!function_exists('enAes128Ecb')) {
    /**
     * @param string $data
     * @param string $key
     * @return string
     * 特殊处理 删掉最后面的两个等号
     */
    function enAes128Ecb(string $data, string $key): string
    {
        return openssl_encrypt($data, 'AES-128-ECB', $key);
    }
}

if (!function_exists('deAes128Ecb')) {
    /**
     * @param string $data
     * @param string $key
     * @return string
     */
    function deAes128Ecb(string $data, string $key): string
    {
        return openssl_decrypt($data, 'AES-128-ECB', $key);
    }
}


if (!function_exists('encryptPhone')) {
    /**
     * @param string $phone
     * @return string
     * 将手机号4-7位用*表示
     */
    function encryptPhone(string $phone): string
    {
        if (strlen($phone) == 11) {
            return substr_replace($phone, '****', 3, 4);
        } else {
            return "***********";
        }
    }
}
