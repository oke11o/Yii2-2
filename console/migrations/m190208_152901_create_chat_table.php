<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%chat}}`.
 */
class m190208_152901_create_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%chat}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'msg' => $this->text()->notNull()
        ]);

        $this->addForeignKey(
            'fk_chat_task', 
            'chat', 
            'task_id', 
            'tasks', 
            'id'
        );

        $this->addForeignKey(
            'fk_chat_user', 
            'chat', 
            'user_id', 
            'user', 
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%chat}}');
    }
}
