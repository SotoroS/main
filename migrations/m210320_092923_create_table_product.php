<?php

use yii\db\Migration;

/**
 * Class m210320_092923_create_table_product
 */
class m210320_092923_create_table_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'image' => $this->string(),
            'description' => $this->string(),
            'price' => $this->string(),
            'special' => $this->string(),
            'tax' => $this->string(),
            'minimum' => $this->string(),
            'rating' => $this->integer(),
            'url' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210320_092923_create_table_product cannot be reverted.\n";

        return false;
    }
    */
}
