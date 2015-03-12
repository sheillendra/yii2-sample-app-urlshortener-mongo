<?php


use yii\db\Schema;

class m150312_015857_init extends \yii\mongodb\Migration
{
    public function up()
    {
        $tableOptions = null;

        $this->createCollection('user',[
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING . ' NOT NULL',

            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->createCollection('shortener');
    }

    public function down()
    {
        echo "m150312_015857_init cannot be reverted.\n";

        return false;
    }
}
