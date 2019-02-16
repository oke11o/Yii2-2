<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller as Controller;

class TelegramController extends Controller {
    public function actionReceive() {
        $bot = \Yii::$app->bot;
        $bot->setCurlOption(CURLOPT_TIMEOUT, 20);
        $bot->setCurlOption(CURLOPT_CONNECTTIMEOUT, 10);
        $bot->setCurlOption(CURLOPT_HTTPHEADER, ['Expect: ']);

        $updates = $bot->getUpdates();
        $messages = [];
        foreach($updates as $update) {
            $message = $update->getMessage();
            //$username = $message->getFrom()->getUsername();
            $username = $message->getFrom()->getFirstName() . " " . $message->getFrom()->getLastName();
            $messages[] = [
                'text' => $message->getText(),
                'username' => $username
            ];
        }

        return $this->render('receive', ['messages' => $messages]);
    }

    public function actionSend() {
        $bot = \Yii::$app->bot;
        $bot->sendMessage(559374237 , 'Из yii с любовью');
    }
}