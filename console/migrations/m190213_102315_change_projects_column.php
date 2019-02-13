<?php

use yii\db\Migration;

/**
 * Class m190213_102315_change_projects_column
 */
class m190213_102315_change_projects_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('project', 'status_id', $this->integer()->defaultValue(1));

        $this->addColumn('project', 'description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('project', 'status_id', $this->integer());

        $this->dropColumn('project', 'description');
    }
}
