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
            'post_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()
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
