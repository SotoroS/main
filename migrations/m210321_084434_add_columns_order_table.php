<?php

use yii\db\Migration;

/**
 * Class m210321_084434_add_columns_order_table
 */
class m210321_084434_add_columns_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('order', 'datetime', $this->integer());
        $this->addColumn('order', 'user_id', $this->integer());

        $this->createIndex(
            'idx-order-user_id',
            'order',
            'user_id'
        );

        // add foreign key for table `school_event`
        $this->addForeignKey(
            'fk-order-user_id',
            'order',
            'user_id',
            'event',
            'uid',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `event`
        $this->dropForeignKey(
            'fk-order-user_id',
            'order'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-order-user_id',
            'order'
        );

        $this->dropColumn('order', 'datetime');
        $this->dropColumn('order', 'user_id');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210321_084434_add_columns_order_table cannot be reverted.\n";

        return false;
    }
    */
}
