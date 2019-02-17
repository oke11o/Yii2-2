<?php
namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\Event;
use common\models\tables\Tasks;
use common\models\tables\Project;
use common\models\tables\TelegramSubscribe;

class StartApp extends Component {
    public $emailApp = 'my@mail.ru';

    public function init() {
        $this->attachEventHandlers();
        Yii::$app->lang->setLanguageApp();
        $this->attachProjectListenet();
    }

    private function attachEventHandlers() {
        $handlerMail = function($event) {
            Yii::$app->mailer->compose()
                ->setTo($event->task->user->email)
                ->setFrom($this->emailApp)
                ->setSubject('TaskTracker: На Вас назначена новая задача')
                ->setHtmlBody($this->shortDescriptionTask($event->task))
                ->send();
        };

        Event::on(Tasks::class, Tasks::EVENT_AFTER_INSERT, $handlerMail);
    }

    private function shortDescriptionTask($task) {
        $description = '';

        if ($task->name) {
            $description .= '<b>Название задачи: </b>';
            $description .= $task->name;
        }

        if ($task->date) {
            $description .= '<br>';
            $description .= '<b>Срок исполнения задачи: </b>';
            $description .= $task->date;
        }

        if ($task->description) {
            $description .= '<br>';
            $description .= '<b>Описание задачи: </b>';
            $description .= $task->description;
        }

        return $description;
    }

    private function listenerProject($event, $response) {
        $listenerProject = TelegramSubscribe::find()
            ->select('chat-id')
            ->where(['channel' => TelegramSubscribe::CHANNEL_PROJECT_CREATE])
            ->column();

        $response .= "Название проекта: {$event->sender->name}.\n";
        if ($event->sender->description) {
            $response .= "Описание проекта: {$event->sender->description}.\n";
        }
        $response .= "Статус проекта: {$event->sender->status->name}.\n";

        $bot = \Yii::$app->bot;
        foreach($listenerProject as $listener) {
            $bot->sendMessage($listener, $response);
        }
    }

    private function attachProjectListenet() {
        Event::on(Project::class, Project::EVENT_BEFORE_INSERT, function(Event $event) {
            $response = "Создан проект\n";
            $this->listenerProject($event, $response);
        });

        Event::on(Project::class, Project::EVENT_BEFORE_UPDATE, function(Event $event) {
            $response = "Обновлен проект\n";
            $this->listenerProject($event, $response);
        });
    }
}
