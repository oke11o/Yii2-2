<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project}}`.
 */
class m190213_095059_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'status_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_project_status', 
            'project', 
            'status_id', 
            'status', 
            'id'
        );

        $this->addColumn('tasks', 'project_id', $this->integer());

        $this->addForeignKey(
            'fk_tasks_project', 
            'tasks', 
            'project_id', 
            'project', 
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_tasks_project',
            'tasks'
        );

        $this->dropColumn('tasks', 'project_id');

        $this->dropTable('{{%project}}');
    }
}
