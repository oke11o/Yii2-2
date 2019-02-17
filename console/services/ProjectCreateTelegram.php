<?php
namespace console\services;

use yii\db\Exception;
use common\models\tables\Project;

class ProjectCreateTelegram {
    public $response;

    public function __construct($params) {
        $model = new Project([
            'name' => $params[1],
            'description' => $params[2]
        ]);
        try {
            if ($model->save()) {
                $this->response = "Создание проекта прошло успешно";
            } else {
                $this->response = "Ошибка при создании проекта!\nКоманда должна быть в формате:\n/project_create ##project_name## ##description## Имя проекта - обязательный параметр!";
            }
        } catch (Exception $e) {
            $this->response = "Ошибка при создании проекта!\nКоманда должна быть в формате:\n/project_create ##project_name## ##description## Имя проекта - обязательный параметр!\nОшибка при сохранении: " . $e->getMessage();
        }
    }
}