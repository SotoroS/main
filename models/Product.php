<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $image
 * @property string|null $description
 * @property string|null $price
 * @property string|null $special
 * @property string|null $tax
 * @property string|null $minimum
 * @property int|null $rating
 * @property string|null $url
 * @property int|null $stream_id
 * @property int|null $product_id
 *
 * @property Stream $stream
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rating', 'stream_id', 'product_id'], 'integer'],
            [['activity'], 'boolean'],
            [['name', 'image', 'description', 'price', 'special', 'tax', 'minimum', 'url'], 'string', 'max' => 255],
            [['stream_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stream::className(), 'targetAttribute' => ['stream_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'image' => 'Изображение',
            'description' => 'Описание',
            'price' => 'Цена',
            'special' => 'Скидка',
            'tax' => 'Tax',
            'minimum' => 'Минимум',
            'rating' => 'Рейтинг',
            'url' => 'Ссылка на товар',
            'stream_id' => 'Stream ID',
            'product_id' => 'Product ID',
            'activity' => 'Активность',
        ];
    }

    /**
     * Gets query for [[Stream]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStream()
    {
        return $this->hasOne(Stream::className(), ['id' => 'stream_id']);
    }
}
