<?php

use yii\db\Migration;

/**
 * Class m210320_123032_add_columns_to_table_product
 */
class m210320_123032_add_columns_to_table_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product', 'stream_id', $this->integer());
        $this->addColumn('product', 'product_id', $this->integer());

        // creates index for column `stream_id`
        $this->createIndex(
            'idx-product-stream_id',
            'product',
            'stream_id'
        );

        // add foreign key for table `school_event`
        $this->addForeignKey(
            'fk-product-stream_id',
            'product',
            'stream_id',
            'stream',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `stream`
        $this->dropForeignKey(
            'fk-product-stream_id',
            'product'
        );

        // drops index for column `stream_id`
        $this->dropIndex(
            'idx-product-stream_id',
            'product'
        );

        $this->dropColumn('product', 'stream_id');
        $this->dropColumn('product', 'product_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210320_123032_add_columns_to_table_product cannot be reverted.\n";

        return false;
    }
    */
}
