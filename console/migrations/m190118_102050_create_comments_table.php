<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comments`.
 */
class m190118_102050_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comments', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
            'content' =>  $this->text(),
            'img_path' => $this->string(),
            'user_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk_comments_user', 
            'comments', 
            'user_id', 
            'user', 
            'id'
        );

        $this->addForeignKey(
            'fk_comments_task', 
            'comments', 
            'task_id', 
            'tasks', 
            'id'
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

        $this->dropForeignKey(
            'fk_comments_user',
            'comments'
        );

        $this->dropTable('comments');
    }
}
