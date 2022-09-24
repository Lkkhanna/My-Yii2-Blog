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
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'body' => $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext')->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer()
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
