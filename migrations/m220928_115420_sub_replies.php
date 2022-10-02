<?php

use yii\db\Migration;

/**
 * Class m220928_115420_replies
 */
class m220928_115420_sub_replies extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sub_replies', [
            'id' => $this->primaryKey(),
            'reply_id' => $this->integer()->notNull(),
            'reply_message' => $this->string(255)->notNull(),
            'created_by' => $this->integer(),
            'created_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('sub_replies');
    }
}
