<?php

use yii\db\Migration;

/**
 * Class m210320_184713_create_table_event
 */
class m210320_184713_create_table_event extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->string(),
            'type' => $this->integer(),
            'datetime' => $this->integer(),
            'stream_id' => $this->integer(),
            'socket_id' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `stream_id`
        $this->createIndex(
            'idx-event-stream_id',
            'event',
            'stream_id'
        );

        // add foreign key for table `school_event`
        $this->addForeignKey(
            'fk-event-stream_id',
            'event',
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
            'fk-event-stream_id',
            'event'
        );

        // drops index for column `stream_id`
        $this->dropIndex(
            'idx-event-stream_id',
            'event'
        );

        $this->dropTable('{{%event}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210320_184713_create_table_event cannot be reverted.\n";

        return false;
    }
    */
}
