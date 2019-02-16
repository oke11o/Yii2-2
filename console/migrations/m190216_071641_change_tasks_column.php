<?php

use yii\db\Migration;

/**
 * Class m190216_071641_change_tasks_column
 */
class m190216_071641_change_tasks_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('tasks', 'project_id', $this->integer()->notNull()->defaultValue(1));
        $this->alterColumn('tasks', 'id_status', $this->integer()->notNull()->defaultValue(1));
        $this->alterColumn('user', 'language_id', $this->integer()->notNull()->defaultValue(1));
        $this->alterColumn('project', 'status_id', $this->integer()->notNull()->defaultValue(1));
        $this->alterColumn('tasks', 'responsible_id', $this->integer()->notNull()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('tasks', 'project_id', $this->integer());
        $this->alterColumn('tasks', 'id_status', $this->integer()->defaultValue(1));
        $this->alterColumn('user', 'language_id', $this->integer()->defaultValue(1));
        $this->alterColumn('project', 'status_id', $this->integer()->defaultValue(1));
        $this->alterColumn('tasks', 'responsible_id', $this->integer());
    }
}
