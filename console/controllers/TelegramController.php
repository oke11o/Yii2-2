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
use yii\db\Exception;

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
                $response = "Доступные команды: \n";
                $response .= "/help - список команд \n";
                $response .= "/project_create ##project_name## - создание нового проекта \n";
                $response .= "/task_create ##task_name## ##2019-01-10(deadline)## ##description## ##responsible_id## ##project_id## - создание новой задачи. Имя задачи и дата выполнения - обязательные параметры!\n";
                $response .= "/sp_create - подписка на создание и обновление проектов \n";
                break;
            case '/sp_create':
                $model = new TelegramSubscribe([
                    'chat-id' => $message->getFrom()->getId(),
                    'channel' => TelegramSubscribe::CHANNEL_PROJECT_CREATE
                ]);
                if ($model->save()) {
                    $response = "Вы подписаны на создание и обновление проектов";
                } else {
                    $response = "Ошибка при подписке на создание и обновление проектов";
                }
                break;
            case '/task_create':
                $model = new Tasks([
                    'name' => $params[1],
                    'date' => $params[2],
                    'description' => $params[3],
                    'responsible_id' => $params[4],
                    'project_id' => $params[5]
                ]);
                try {
                    if ($model->save()) {
                        $response = "Создание задачи прошло успешно";
                    } else {
                        $response = "Ошибка при создании задачи!\nКоманда должна быть в формате:\n/task_create ##task_name## ##2019-01-10(deadline)## ##description## ##responsible_id## ##project_id## Имя задачи и дата выполнения - обязательные параметры!";
                    }
                } catch (Exception $e) {
                    $response = "Ошибка при создании задачи!\nКоманда должна быть в формате:\n/task_create ##task_name## ##2019-01-10(deadline)## ##description## ##responsible_id## ##project_id## Имя задачи и дата выполнения - обязательные параметры!\nОшибка при сохранении: " . $e->getMessage();
                }
                break;
            case '/project_create':
                $model = new Project([
                    'name' => $params[1],
                    'description' => $params[2]
                ]);
                try {
                    if ($model->save()) {
                        $response = "Создание проекта прошло успешно";
                    } else {
                        $response = "Ошибка при создании проекта!\nКоманда должна быть в формате:\n/project_create ##project_name## ##description## Имя проекта - обязательный параметр!";
                    }
                } catch (Exception $e) {
                    $response = "Ошибка при создании проекта!\nКоманда должна быть в формате:\n/project_create ##project_name## ##description## Имя проекта - обязательный параметр!\nОшибка при сохранении: " . $e->getMessage();
                }
                break;
        }

        $this->bot->sendMessage($message->getFrom()->getId(), $response);
    }
}