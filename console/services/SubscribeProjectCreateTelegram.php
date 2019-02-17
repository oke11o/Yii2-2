<?php
namespace console\services;

use TelegramBot\Api\Types\Message;
use common\models\tables\TelegramSubscribe;

class SubscribeProjectCreateTelegram {
    public $response;

    public function __construct($chatId) {
        $model = TelegramSubscribe::find()
            ->where([
                'chat-id' => $chatId,
                'channel' => TelegramSubscribe::CHANNEL_PROJECT_CREATE
            ])->all();
        if ($model) {
            $this->response = "Вы были раннее подписаны на создание и обновление проектов";
        } else {
            $model = new TelegramSubscribe([
                'chat-id' => $chatId,
                'channel' => TelegramSubscribe::CHANNEL_PROJECT_CREATE
            ]);
            if ($model->save()) {
                $this->response = "Вы подписаны на создание и обновление проектов";
            } else {
                $this->response = "Ошибка при подписке на создание и обновление проектов";
            }
        }
    }
}