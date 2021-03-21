<?php

use yii\db\Migration;

/**
 * Class m210320_055255_create_table_live
 */
class m210320_055255_create_table_live extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stream}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'youtube_url' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stream}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210320_055255_create_table_live cannot be reverted.\n";

        return false;
    }
    */
}
