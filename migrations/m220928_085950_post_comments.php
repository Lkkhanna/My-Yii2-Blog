<?php

use yii\db\Migration;

/**
 * Class m220928_085950_post_comments
 */
class m220928_085950_post_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post_comments', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'comment' => $this->string(255)->notNull(),
            'created_by' => $this->integer(),
            'created_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('post_comments');
    }
}
