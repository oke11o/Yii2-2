<?php

namespace common\models\tables;

use Yii;

/**
 * This is the model class for table "role_command".
 *
 * @property int $id
 * @property string $name
 *
 * @property CommandUser[] $commandUsers
 */
class RoleCommand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role_command';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommandUsers()
    {
        return $this->hasMany(CommandUser::className(), ['id_role_command' => 'id']);
    }
}
