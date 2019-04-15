<?php

use sbs\components\DbMigration;

/**
 * Class m000000_000002_news
 */
class m000000_000002_news extends DbMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull()->unique(),
            'description' => $this->text(),
            'parent_id' => $this->integer(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0),
            'create_date' => $this->dateTime()->notNull(),
            'update_date' => $this->dateTime()->notNull(),
        ], $this->getOptions());
        $this->addForeignKey(
            'fk_news_cat_parent', '{{%news_category}}', 'parent_id', '{{%news_category}}', 'id', 'cascade', 'cascade'
        );

        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull()->unique(),
            'image' => $this->string(),
            'preview' => $this->text(),
            'text' => $this->text()->notNull(),
            'views' => $this->integer(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0),
            'publish_date' => $this->dateTime()->notNull(),
            'create_user' => $this->integer(),
            'update_user' => $this->integer(),
            'create_date' => $this->dateTime()->notNull(),
            'update_date' => $this->dateTime()->notNull(),
        ], $this->getOptions());
        $this->addForeignKey(
            'fk_news_category', '{{%news}}', 'category_id', '{{%news_category}}', 'id', 'set null', 'no action');
        $this->addForeignKey(
            'fk_news_create_user', '{{%news}}', 'create_user', '{{%user_master}}', 'id', 'set null', 'no action'
        );
        $this->addForeignKey(
            'fk_news_update_user', '{{%news}}', 'update_user', '{{%user_master}}', 'id', 'set null', 'no action'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news}}');
        $this->dropTable('{{%news_category}}');
    }
}
