<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string|null $order
 * @property int|null $stream_id
 * @property int|null $datetime
 * @property int|null $user_id
 *
 * @property Stream $stream
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stream_id', 'datetime', 'user_id'], 'integer'],
            [['order'], 'string', 'max' => 255],
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
            'order' => 'Order',
            'stream_id' => 'Stream ID',
            'datetime' => 'Datetime',
            'user_id' => 'User ID',
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
