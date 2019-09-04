<?php

use app\models\user\User;
use app\models\user\UserProfile;
use sbs\components\DbMigration;

class m000000_000001_user extends DbMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id'                   => $this->primaryKey(),
            'email'                => $this->string()->notNull()->unique(),
            'email_confirm_token'  => $this->string(32)->unique(),
            'auth_key'             => $this->string(32)->notNull(),
            'password_hash'        => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status'               => $this->tinyInteger()->notNull()->defaultValue(User::STATUS_PENDING),
            'create_date'          => $this->dateTime()->notNull(),
            'update_date'          => $this->dateTime()->notNull(),
            'last_visit'           => $this->dateTime(),
        ], $this->getOptions());

        $this->createTable('{{%user_profile}}', [
            'user_id'   => $this->primaryKey(),
            'name'      => $this->string(),
            'phone'     => $this->string(),
            'DOB'       => $this->date(),
            'gender'    => $this->tinyInteger()->defaultValue(UserProfile::GENDER_THING),
            'subscribe' => $this->tinyInteger()->defaultValue(UserProfile::SUBSCRIBE_NOT_ACTIVE),
            'info'      => $this->text(),
        ], $this->getOptions());

        $this->addForeignKey(
            'fk_user_profile',
            '{{%user_profile}}',
            'user_id',
            '{{%user}}',
            'id',
            'cascade',
            'no action'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_profile}}');
        $this->dropTable('{{%user}}');
    }
}
