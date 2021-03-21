<?php

use yii\db\Migration;

/**
 * Class m210320_122723_add_column_to_table_stream
 */
class m210320_122723_add_column_to_table_stream extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('stream', 'domain', $this->string());
        $this->addColumn('stream', 'api_key', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('stream', 'domain');
        $this->dropColumn('stream', 'api_key');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210320_122723_add_column_to_table_stream cannot be reverted.\n";

        return false;
    }
    */
}
