<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property string|null $uid
 * @property int|null $type
 * @property int|null $datetime
 * @property int|null $stream_id
 * @property string|null $socket_id
 *
 * @property Stream $stream
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'datetime', 'stream_id'], 'integer'],
            [['uid', 'socket_id'], 'string', 'max' => 255],
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
            'uid' => 'Uid',
            'type' => 'Type',
            'datetime' => 'Datetime',
            'stream_id' => 'Stream ID',
            'socket_id' => 'Socket ID',
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
