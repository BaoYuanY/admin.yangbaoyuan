<?php

namespace App\Http\Service\common;

use App\Models\common\FeishuRobotConfigModel;
use Guanguans\Notify\Factory;
use Guanguans\Notify\Messages\FeiShu\CardMessage;
use Illuminate\Support\Facades\Log;

class SendFeishuMsgService
{

    /**
     * 组建消息
     * @param string $title
     * @param string $color
     * @param array $content
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

    public static function send(string $title, string $color, array $content, FeishuRobotConfigModel $robot)
    {
        Log::channel('feishuSend')->info(
            '发送内容：' . json_encode([
                'title'   => $title,
                'color'   => $color,
                'content' => $content,
                'robot'   => $robot->id,
            ], JSON_UNESCAPED_UNICODE)
        );
        $arr        = self::formationMsg($title, $color, $content);
        $sendResult = Factory::feiShu()
            ->setToken($robot->token)
            ->setSecret($robot->secret)
            ->setMessage(new CardMessage($arr))
            ->send();
        Log::channel('feishuSend')->info(
            '发送结果：' . json_encode($sendResult, JSON_UNESCAPED_UNICODE)
        );
    }

}
