<?php

namespace common\models\tables;

use Yii;

/**
 * This is the model class for table "command_user".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_command
 * @property int $id_role_command
 *
 * @property Command $command
 * @property RoleCommand $roleCommand
 * @property User $user
 */
class CommandUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'command_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_command', 'id_role_command'], 'required'],
            [['id_user', 'id_command', 'id_role_command'], 'integer'],
            [['id_command'], 'exist', 'skipOnError' => true, 'targetClass' => Command::className(), 'targetAttribute' => ['id_command' => 'id']],
            [['id_role_command'], 'exist', 'skipOnError' => true, 'targetClass' => RoleCommand::className(), 'targetAttribute' => ['id_role_command' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'User',
            'id_command' => 'Command',
            'id_role_command' => 'Role Command',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommand()
    {
        return $this->hasOne(Command::className(), ['id' => 'id_command']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleCommand()
    {
        return $this->hasOne(RoleCommand::className(), ['id' => 'id_role_command']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function insert($runValidation = true, $attributeNames = NULL) {
        $model = CommandUser::find()
            ->where([
                'id_user' => $this->id_user,
                'id_command' => $this->id_command
            ])->one();
        if ($model) {
            return "Нельзя добавить одного пользователя в команду дважды!";
        } else {
            parent::insert();
        }
    }
}
