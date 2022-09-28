<?php

use yii\db\Migration;

/**
 * Class m220927_062050_PostsImages
 */
class m220927_062050_PostImages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post_images', [
            'post_id' => $this->integer()->notNull(),
            'image' => $this->string(40)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('post_images'); 
    }

}
