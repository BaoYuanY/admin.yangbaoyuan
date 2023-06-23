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
        } elseif (preg_match('/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2})$/', $string, $matches)) {
            // 第二个条件：检查输入是否为时间格式（精确到分钟）
            list(, $year, $month, $day, $hour, $minute) = $matches;
            $inputTime = mktime($hour, $minute, 0, $month, $day, $year);

            $currentMinute = (int)($currentTime / 60);
            $inputMinute = (int)($inputTime / 60);

            return $inputMinute == $currentMinute;
        }

        return false;
    }
}
