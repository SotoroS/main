<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stream".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $youtube_url
 * @property string|null $domain
 * @property string|null $api_key
 *
 * @property Product[] $products
 */
class Stream extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stream';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'youtube_url', 'domain', 'api_key'], 'string', 'max' => 255],
            [['name', 'youtube_url', 'domain', 'api_key'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'youtube_url' => 'Ссылка YouTube',
            'domain' => 'Домен',
            'api_key' => 'Ключ API',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['stream_id' => 'id']);
    }

    /**
     * Gets query for [[Events]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['stream_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['stream_id' => 'id']);
    }
}
