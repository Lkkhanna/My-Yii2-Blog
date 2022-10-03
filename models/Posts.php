<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 *
 * @property Users $createdBy
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    public $categories;
    public $image;

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title'
            ]
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'body'], 'required'],
            [['body'], 'string', 'min' => 5],
            [['created_at', 'updated_at'], 'safe'],
            ['created_at', 'date', 'format' => 'yyyy-M-d H:m:s'],
            ['updated_at', 'date', 'format' => 'yyyy-M-d H:m:s'],
            [['created_by'], 'integer'],
            [['title'], 'string', 'min' => 2, 'max' => 50],
            [['slug'], 'string', 'min' => 2, 'max' => 100],
            [['title', 'slug'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['status'], 'required'],
            [['categories'], 'required'],
            ['image', 'required'],
            [['image'], 'file', 'maxFiles' => 5, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'body' => 'Body',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'images' => 'Post Images',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /** Get Images by post_id */
    public static function getImagesOfPost($slug)
    {
        $post = self::findOne(['slug' => $slug]);
        if (!empty($post)) {
            return PostImages::find()->where(['post_id' => $post->id])->all();
        }
        return false;
    }

    /** Get Comments by post_id */
    public static function getPostComments($slug)
    {
        $post = self::findOne(['slug' => $slug]);
        if (!empty($post)) {
            return PostComments::find()->where(['post_id' => $post->id])->all();
        }
        return false;
    }

    /** Get Replies by comment_id */
    public static function getCommentReplies($comment_id)
    {
        if (!empty($comment_id)) {
            return PostCommentReplies::find()->where(['comment_id' => $comment_id])->all();
        }
        return false;
    }

    /** Get Sub Replies by reply_id */
    public static function getSubReplies($reply_id)
    {
        if (!empty($reply_id)) {
            return SubReplies::find()->where(['reply_id' => $reply_id])->all();
        }
        return false;
    }
    
}
