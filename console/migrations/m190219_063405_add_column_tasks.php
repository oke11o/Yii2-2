<?php

use yii\db\Migration;

/**
 * Class m190219_063405_add_column_tasks
 */
class m190219_063405_add_column_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tasks', 'execution_date', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('tasks', 'execution_date');        
    }
}
