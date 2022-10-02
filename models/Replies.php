<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "replies".
 *
 * @property int $id
 * @property int $reply_id
 * @property string $reply_message
 * @property int|null $created_by
 * @property string|null $created_at
 */
class Replies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'replies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reply_id', 'reply_message'], 'required'],
            [['reply_id', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['reply_message'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reply_id' => 'Reply ID',
            'reply_message' => 'Reply Message',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }
}
