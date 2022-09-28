<?php

use yii\db\Migration;

/**
 * Class m220922_143433_posts
 */
class m220922_143433_posts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('posts', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull()->unique(),
            'slug' => $this->string(100)->notNull(),
            'body' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext')->notNull(),
            'status' => $this->tinyInteger()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);

        $this->addForeignKey('FK_post_user', 'posts', 'created_by', 'users', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropForeignKey('FK_post_user', 'posts');
       $this->dropTable('posts');
    }

}
