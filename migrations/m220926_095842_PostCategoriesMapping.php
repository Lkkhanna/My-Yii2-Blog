<?php

use yii\db\Migration;

/**
 * Class m220926_095842_PostCategoriesMapping
 */
class m220926_095842_PostCategoriesMapping extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post_categories_mapping', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'category_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('post_categories_mapping');
    }

}
