<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_images".
 *
 * @property int $post_id
 * @property string $image
 */
class PostImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'image'], 'required'],
            [['post_id'], 'integer'],
            [['image'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'image' => 'Image',
        ];
    }
}
