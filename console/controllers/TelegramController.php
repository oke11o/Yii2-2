<?php
namespace console\controllers;

use Yii;
use DateTime;
use yii\console\Controller;
use common\models\tables\TelegramOffset;
use common\models\tables\TelegramSubscribe;
use common\models\tables\Tasks;
use common\models\tables\Project;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Types\Update;
use console\services\HelpTelegram;
use console\services\SubscribeProjectCreateTelegram;
use console\services\ProjectCreateTelegram;
use console\services\TaskCreateTelegram;

class TelegramController extends Controller{
    private $bot;
    private $offset = 0;

    public function init() {
        parent::init();
        $this->bot = \Yii::$app->bot;
    }

    public function actionIndex() {
        $updates = $this->bot->getUpdates($this->getOffset() + 1);
        $updCount = count($updates);
        if ($updCount > 0) {
            foreach ($updates as $update) {
                $this->updateOffset($update);
                if ($message = $update->getMessage()) {
                    $this->processCommand($message);
                }
            }
            echo "Новых сообщений: " . $updCount . PHP_EOL;
        } else {
            echo "Новых сообщений нет" . PHP_EOL;
        }
    }

    private function getOffset() {
        $max = TelegramOffset::find()->
            select('id')
            ->max('id');

        if ($max > 0) {
            $this->offset = $max;
        }
        return $this->offset;
    }

    private function updateOffset(Update $update) {
        $model = new TelegramOffset([
            'id' => $update->getUpdateId(),
            'timestamp' => date("Y-m-d H:i:s")
        ]);
        $model->save();
    }

    private function processCommand(Message $message) {
        $params = explode(" ", $message->getText());
        $command = $params[0];
        $response = "Unknown command";

        switch($command) {
            case '/help':
                $response = (new HelpTelegram())->response;
                break;
            case '/sp_create':
                $response = (new SubscribeProjectCreateTelegram($message->getFrom()->getId()))->response;
                break;
            case '/task_create':
                $response = (new TaskCreateTelegram($params))->response;
                break;
            case '/project_create':
                $response = (new ProjectCreateTelegram($params))->response;
                break;
        }

        $this->bot->sendMessage($message->getFrom()->getId(), $response);
    }
}