<?php

use yii\db\Migration;

/**
 * Class m190219_114048_change
 */
class m190219_114048_change extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(
            'fk_comments_task',
            'comments'
        );

        $this->addForeignKey(
            'fk_comments_task', 
            'comments', 
            'task_id', 
            'tasks', 
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_comments_task',
            'comments'
        );

        $this->addForeignKey(
            'fk_comments_task', 
            'comments', 
            'task_id', 
            'tasks', 
            'id'
        );
    }
}
