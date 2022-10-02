<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_comment_replies".
 *
 * @property int $id
 * @property int $comment_id
 * @property string $reply
 * @property int|null $created_by
 * @property string|null $created_at
 */
class PostCommentReplies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_comment_replies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment_id', 'reply'], 'required'],
            [['comment_id', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['reply'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comment_id' => 'Comment ID',
            'reply' => 'Reply',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }
}
