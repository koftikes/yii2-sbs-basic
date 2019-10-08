<?php

use sbs\components\DbMigration;

/**
 * Class m000000_000003_static_page.
 */
class m000000_000003_static_page extends DbMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%static_page}}', [
            'id'          => $this->primaryKey(),
            'title'       => $this->string()->notNull(),
            'slug'        => $this->string()->notNull()->unique(),
            'text'        => $this->text(),
            'update_date' => $this->dateTime()->notNull(),
        ], $this->getOptions());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%static_page}}');
    }
}
