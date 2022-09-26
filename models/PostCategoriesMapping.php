<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_categories_mapping".
 *
 * @property int $id
 * @property int|null $post_id
 * @property int|null $category_id
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class PostCategoriesMapping extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_categories_mapping';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'category_id', 'created_at', 'updated_at'], 'integer'],
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
            'category_id' => 'Category ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
