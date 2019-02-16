<?php
namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\Event;
use common\models\tables\Tasks;

class StartApp extends Component {
    public $emailApp = 'my@mail.ru';

    public function init() {
        $this->attachEventHandlers();
        Yii::$app->lang->setLanguageApp();
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
}
