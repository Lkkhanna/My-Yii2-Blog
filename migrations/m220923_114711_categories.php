<?php

use yii\db\Migration;

/**
 * Class m220923_114711_categories
 */
class m220923_114711_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull()->unique(),
            'body' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext')->notNull(),
            'created_by' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('categories');
    }

}
