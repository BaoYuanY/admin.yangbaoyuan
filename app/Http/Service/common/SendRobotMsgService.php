<?php

namespace App\Http\Service\common;

use App\Models\common\RobotConfigModel;
use Carbon\Carbon;
use Guanguans\Notify\Factory;
use Guanguans\Notify\Messages\FeiShu\CardMessage;
use Illuminate\Support\Facades\Log;

class SendRobotMsgService
{

    /**
     * 组建飞书发送消息体
     * @param string $title
     * @param string $color
     * @param array $content 支持两种方式  一种是key->value格式  一种是['attribute'=>属性,'value'=>值]
     * @return array
     */
    public static function formationMsg(string $title, string $color, array $content): array
    {
        $contentList = [];
        $contentJson = file_get_contents(resource_path() . '/Feishu/MessageTemplate/BaseTwoColumnElements.json');
        $headerArr   = json_decode(sprintf(file_get_contents(resource_path() . '/Feishu/MessageTemplate/BaseTwoColumnHeader.json'), $color, $title), true);
        //创建消息体
        foreach ($content as $key => $row) {
            if (is_array($row)) {
                $contentList[] = json_decode(sprintf($contentJson, $row['attribute'], $row['value']), true);
            }
            if (is_string($row)) {
                $contentList[] = json_decode(sprintf($contentJson, $key, $row), true);
            }
        }
        $headerArr['elements'] = $contentList;
        return $headerArr;
    }

    /**
     * 发送飞书通知
     * @param string $title
     * @param array $content
     * @param RobotConfigModel $robot
     * @param string $color
     * @return void
     */
    public static function sendByFeishu(string $title, array $content, RobotConfigModel $robot, string $color = 'blue')
    {
        //添加发送日志
        self::addCreateSendLog($robot->platformText, json_encode([
            'title'   => $title,
            'color'   => $color,
            'content' => $content,
            'robot'   => $robot->id,
        ], JSON_UNESCAPED_UNICODE));

        $arr        = self::formationMsg($title, $color, $content);
        $sendResult = Factory::feiShu()
            ->setToken($robot->token)
            ->setSecret($robot->secret)
            ->setMessage(new CardMessage($arr))
            ->send();

        self::addResultSendLog(json_encode($sendResult, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 测试
     * @return void
     */
    public static function sendByFeishuTest()
    {
        $content = [
            [
                'attribute' => '日期：',
                'value' => Carbon::now()->format('Y-m-d'),
            ],
            [
                'attribute' => '时间：',
                'value' => Carbon::now()->format('H:i:s'),
            ],
            [
                'attribute' => '星期：',
                'value' => Carbon::now()->dayOfWeekIso,
            ]
        ];
        $robotConfigModel = RobotConfigModel::query()->where('id', 1)->first();
        SendRobotMsgService::sendByFeishu('时间', $content, $robotConfigModel);
        Log::channel('robotSend')->info('发送测试消息');
    }


    /**
     * 记录发送日志
     * @param string $platform
     * @param string $contentJson
     * @return void
     */
    public static function addCreateSendLog(string $platform, string $contentJson)
    {
        Log::channel('robotSend')->info('发送平台：' . $platform . '发送内容：' . $contentJson);
    }


    /**
     * 记录发送结果日志
     * @param string $contentJson
     * @return void
     */
    public static function addResultSendLog(string $contentJson)
    {
        Log::channel('robotSend')->info('发送结果：' . $contentJson);
    }

}
