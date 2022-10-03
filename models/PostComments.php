<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_comments".
 *
 * @property int $id
 * @property int $post_id
 * @property string $comment
 * @property int|null $created_by
 * @property string|null $created_at
 */
class PostComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'comment'], 'required'],
            [['post_id', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
            ['created_at', 'date', 'format' => 'yyyy-M-d H:m:s'],
            [['comment'], 'string', 'min' => 1, 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'comment' => 'Comment',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }
}
