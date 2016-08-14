<?php

use yii\db\Migration;
use yii\db\Schema;

class m160329_231124_ville extends Migration
{
    public function up()
    {
        $this->createTable('ville',
            [
                'id'=>Schema::TYPE_PK,
                'id_parent'=>Schema::TYPE_INTEGER,
                'name'=>Schema::TYPE_STRING,
                'status'=>Schema::TYPE_BOOLEAN,
                'level'=>Schema::TYPE_INTEGER,

            ]);

    }

    public function down()
    {
        $this->dropTable('ville');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
