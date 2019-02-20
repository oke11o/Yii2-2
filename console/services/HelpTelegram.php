<?php
namespace console\services;

class HelpTelegram {
    public $response;

    public function __construct() {
        $this->response = "Доступные команды: \n";
        $this->response .= "/help - список команд \n";
        $this->response .= "/project_create ##project_name## - создание нового проекта \n";
        $this->response .= "/task_create ##task_name## ##2019-01-10(deadline)## ##description## ##responsible_id## ##project_id## ##create_user_id## - создание новой задачи. Имя задачи и дата выполнения - обязательные параметры!\n";
        $this->response .= "/sp_create - подписка на создание и обновление проектов \n";
    }
}