<?php

use yii\db\Migration;

/**
 * Class m190211_134253_change_chat_table
 */
class m190211_134253_change_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(
            'fk_chat_task',
            'chat'
        );

        $this->renameColumn('chat', 'task_id', 'channel');

        $this->alterColumn('chat', 'channel', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('chat', 'channel', 'task_id');

        $this->addForeignKey(
            'fk_chat_task', 
            'chat', 
            'task_id', 
            'tasks', 
            'id'
        );

        $this->alterColumn('chat', 'task_id', $this->integer()->notNull());
    }

}
