<?php

use yii\db\Migration;

/**
 * Class m190111_160451_create_new_column_task
 */
class m190111_160451_create_new_column_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('status', [
            'id' => $this->primaryKey(),
            'name' => $this->string(25)->notNull()
        ]);

        $this->batchInsert('status', ['name'], [
            ['new'],
            ['in work'],
            ['finish'],
          ]
        );


        $this->addColumn('tasks', 'id_status', 'INT');
        
        $this->addForeignKey(
            'fk_tasks_status', 
            'tasks', 
            'id_status', 
            'status', 
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_tasks_status',
            'tasks'
        );

        $this->dropColumn('tasks', 'id_status');

        $this->dropTable('status');
    }

}
