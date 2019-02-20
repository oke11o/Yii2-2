<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%command}}`.
 */
class m190218_083643_create_command_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('role_command', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()
        ]);

        $this->batchInsert('role_command', ['name'], [
            ['admin'],
            ['user']
          ]
        );

        $this->createTable('{{%command}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

        $this->createTable('command_user', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'id_command' => $this->integer()->notNull(),
            'id_role_command' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk_command_user_user', 
            'command_user', 
            'id_user', 
            'user', 
            'id'
        );

        $this->addForeignKey(
            'fk_command_user_command', 
            'command_user', 
            'id_command', 
            'command', 
            'id'
        );

        $this->addForeignKey(
            'fk_command_user_role_command', 
            'command_user', 
            'id_role_command', 
            'role_command', 
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_command_user_user',
            'command_user'
        );
        $this->dropForeignKey(
            'fk_command_user_command',
            'command_user'
        );
        $this->dropForeignKey(
            'fk_command_user_role_command',
            'command_user'
        );
        
        $this->dropTable('command_user');
        $this->dropTable('{{%command}}');
        $this->dropTable('role_command');
    }
}
