<?php

namespace common\models\tables;

use Yii;
use common\models\tables\TelegramSubscribe;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $name
 * @property int $status_id
 * @property string $description
 *
 * @property Status $status
 * @property Tasks[] $tasks
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status_id' => 'Status',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['project_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->sendInfoUser($insert);
    }

    private function sendInfoUser($insert) {
        $listenerProject = TelegramSubscribe::find()
            ->where(['channel' => TelegramSubscribe::CHANNEL_PROJECT_CREATE])
            ->all();
        $listenerProjectList = ArrayHelper::map($listenerProject, 'id', 'chat-id');

        if ($insert) {
            $response = "Создан проект\n";
        } else {
            $response = "Обновлен проект\n";
        }
        $response .= "Название проекта: {$this->name}.\n";
        if ($this->description) {
            $response .= "Описание проекта: {$this->description}.\n";
        }
        $response .= "Статус проекта: {$this->status->name}.\n";

        $bot = \Yii::$app->bot;
        foreach($listenerProjectList as $listener) {
            $bot->sendMessage($listener, $response);
        }
    }
}
