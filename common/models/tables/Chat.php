<?php

namespace common\models\tables;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property string $channel
 * @property int $user_id
 * @property string $msg
 *
 * @property Tasks $task
 * @property User $user
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['channel', 'user_id', 'msg'], 'required'],
            [['user_id'], 'integer'],
            [['msg', 'channel'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel' => 'Channel',
            'user_id' => 'User ID',
            'msg' => 'Введите сообщение:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
