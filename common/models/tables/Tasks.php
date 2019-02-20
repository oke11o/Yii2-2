<?php

namespace common\models\tables;

use Yii;
use common\events\TaskEvent as TaskEvent;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord as ActiveRecord;
use yii\db\AfterSaveEvent;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $name
 * @property string $date
 * @property string $description
 * @property int $responsible_id
 * 
 * @property Users $user
 */
class Tasks extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'date'], 'required'],
            [['date', 'created_at', 'update_at'], 'safe'],
            [['description'], 'string'],
            [['responsible_id', 'id_status', 'project_id', 'create_user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['responsible_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['responsible_id' => 'id']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['id_status' => 'id']],
            [['responsible_id', 'project_id'], 'default', 'value' => 1],
            ['execution_date', 'required', 'when' => function ($model) {
                return $model->id_status == 3;
            }, 'whenClient' => "function (attribute, value) {
                return document.getElementById('tasks-id_status').value == 3;
            }"],
            //['execution_date', 'compare', 'compareAttribute' => 'created_at', 'operator' => '>=',],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('taskTask', 'nameLabel'),
            'date' => Yii::t('taskTask', 'dateLabel'),
            'description' => Yii::t('taskTask', 'descriptionLabel'),
            'responsible_id' => Yii::t('taskTask', 'responsibleLabel'),
            'created_at' => Yii::t('taskTask', 'createdAtLabel'),
            'update_at' => 'Updated time',
            'id_status' => Yii::t('taskTask', 'statusLabel'),
            'project_id' => Yii::t('taskTask', 'projectLabel'),
            'create_user_id' => Yii::t('taskTask', 'createUserLabel'),
            'execution_date' => Yii::t('taskTask', 'executionDateLabel')
        ];
    }

    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'responsible_id']);
    }

    public function getStatus() {
        return $this->hasOne(Status::class, ['id' => 'id_status']);
    }

    public function getProject() {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    public function getCreateUser() {
        return $this->hasOne(User::class, ['id' => 'create_user_id']);
    }

    public function afterSave($insert, $changedAttributes) {
        if ($insert) {
            $this->trigger(self::EVENT_AFTER_INSERT, new TaskEvent([
                'task' => $this
            ]));
        } else {
            $this->trigger(self::EVENT_AFTER_UPDATE, new AfterSaveEvent([
                'changedAttributes' => $changedAttributes,
            ]));
        }
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['update_at'],
                    ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function extraFields() {
        return ['user', 'status'];
    }
}
