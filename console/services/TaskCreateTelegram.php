<?php
namespace console\services;

use yii\db\Exception;
use common\models\tables\Tasks;

class TaskCreateTelegram {
    public $response;

    public function __construct($params) {
        $model = new Tasks([
            'name' => $params[1],
            'date' => $params[2],
            'description' => $params[3],
            'responsible_id' => $params[4],
            'project_id' => $params[5]
        ]);
        try {
            if ($model->save()) {
                $this->response = "Создание задачи прошло успешно";
            } else {
                $this->response = "Ошибка при создании задачи!\nКоманда должна быть в формате:\n/task_create ##task_name## ##2019-01-10(deadline)## ##description## ##responsible_id## ##project_id## ##create_user_id## Имя задачи и дата выполнения - обязательные параметры!";
            }
        } catch (Exception $e) {
            $this->response = "Ошибка при создании задачи!\nКоманда должна быть в формате:\n/task_create ##task_name## ##2019-01-10(deadline)## ##description## ##responsible_id## ##project_id## ##create_user_id## Имя задачи и дата выполнения - обязательные параметры!\nОшибка при сохранении: " . $e->getMessage();
        }
    }
}