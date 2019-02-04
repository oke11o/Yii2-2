<?php

use yii\db\Migration;

/**
 * Class m181224_104406_create_foreign_key_tasks
 */
class m181224_104406_create_foreign_key_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk_tasks_responsible_id', 
            'tasks', 
            'responsible_id', 
            'user', 
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_tasks_responsible_id',
            'tasks'
        );
    }
}
