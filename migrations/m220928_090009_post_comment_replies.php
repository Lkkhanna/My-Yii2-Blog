<?php

use yii\db\Migration;

/**
 * Class m220928_090009_post_comment_replies
 */
class m220928_090009_post_comment_replies extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post_comment_replies', [
            'id' => $this->primaryKey(),
            'comment_id' => $this->integer()->notNull(),
            'reply' => $this->string(255)->notNull(),
            'created_by' => $this->integer(),
            'created_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('post_comment_replies');
    }
}
