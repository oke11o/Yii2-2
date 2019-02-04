<?php

use yii\db\Migration;

/**
 * Class m190111_133606_add_new_column
 */
class m190111_133606_add_new_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tasks', 'created_at', $this->dateTime());
        $this->addColumn('tasks', 'update_at', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('tasks', 'created_at');
        $this->dropColumn('tasks', 'update_at');
    }
}
