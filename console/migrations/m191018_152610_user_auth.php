<?php

use sbs\components\DbMigration;

/**
 * Class m191018_152610_user_auth.
 */
class m191018_152610_user_auth extends DbMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_auth}}', [
            'id'        => $this->primaryKey(),
            'user_id'   => $this->integer()->notNull(),
            'source'    => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);
        $this->addForeignKey(
            'fk_user_auth',
            '{{%user_auth}}',
            'user_id',
            '{{%user}}',
            'id',
            'cascade',
            'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_auth}}');
    }
}
