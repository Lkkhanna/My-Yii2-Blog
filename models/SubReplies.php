<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sub_replies".
 *
 * @property int $id
 * @property int $reply_id
 * @property string $reply_message
 * @property int|null $created_by
 * @property string|null $created_at
 */
class SubReplies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sub_replies';
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
            ['created_at', 'date', 'format' => 'yyyy-M-d H:m:s'],
            [['reply_message'], 'string', 'min'=> 2, 'max' => 100],
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
