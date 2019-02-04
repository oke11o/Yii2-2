<?php

use yii\db\Migration;

/**
 * Class m190118_151753_add_column_users
 */
class m190118_151753_add_column_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('language', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'value' => $this->string(25)->notNull()
        ]);

        $this->batchInsert('language', ['name', 'value'], [
            ['Русский', 'ru'],
            ['Английский', 'en']
          ]
        );

        $this->addColumn('user', 'language_id', $this->integer()->defaultValue(1));
        
        $this->addForeignKey(
            'fk_users_language', 
            'user', 
            'language_id', 
            'language', 
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_users_language',
            'user'
        );

        $this->dropColumn('user', 'language_id');

        $this->dropTable('language');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190118_151753_add_column_users cannot be reverted.\n";

        return false;
    }
    */
}
