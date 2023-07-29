<?php

namespace App\Models\common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RobotConfigModel extends Model
{
    use HasFactory;

    protected $table = 'robot_config';

    protected $appends = [
        'platformText'
    ];




    const PLATFORM_FEISHU = 1;

    const PLATFORM_MAPPING = [
        self::PLATFORM_FEISHU => '飞书',
    ];

    //platformText访问器
    public function getPlatformTextAttribute(): string
    {
        return self::PLATFORM_MAPPING[$this->platform] ?? "未定义的平台:{$this->platform}";
    }

}
