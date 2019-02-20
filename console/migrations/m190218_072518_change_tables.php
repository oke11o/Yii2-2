<?php

use yii\db\Migration;

/**
 * Class m190218_072518_change_tables
 */
class m190218_072518_change_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tasks', 'create_user_id', $this->integer()->notNull()->defaultValue(1));

        $this->addForeignKey(
            'fk_tasks_create_user', 
            'tasks', 
            'create_user_id', 
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
            'fk_tasks_create_user',
            'tasks'
        );

        $this->dropColumn('tasks', 'create_user_id');
    }
}
