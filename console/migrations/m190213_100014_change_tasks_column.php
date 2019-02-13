<?php

use yii\db\Migration;

/**
 * Class m190213_100014_change_tasks_column
 */
class m190213_100014_change_tasks_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('tasks', 'id_status', $this->integer()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('tasks', 'id_status', $this->integer());
    }
}
