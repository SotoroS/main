<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m210321_062921_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'order' => $this->string(),
            'stream_id' => $this->integer(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `stream_id`
        $this->createIndex(
            'idx-order-stream_id',
            'order',
            'stream_id'
        );

        // add foreign key for table `school_order`
        $this->addForeignKey(
            'fk-order-stream_id',
            'order',
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
            'fk-order-stream_id',
            'order'
        );

        // drops index for column `stream_id`
        $this->dropIndex(
            'idx-order-stream_id',
            'order'
        );

        $this->dropTable('{{%order}}');
    }
}
