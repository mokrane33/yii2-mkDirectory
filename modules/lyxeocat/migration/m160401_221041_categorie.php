<?php

use yii\db\Migration;
use yii\db\Schema;

class m160401_221041_categorie extends Migration
{
    public function up()
    {
        $this->createTable('{{%category}}',
            [
                'id'=>Schema::TYPE_PK,
                'id_parent'=>Schema::TYPE_INTEGER,
                'name'=>Schema::TYPE_STRING,
                'status'=>Schema::TYPE_BOOLEAN,
                'level'=>Schema::TYPE_INTEGER,
                'image'=>Schema::TYPE_STRING,
                'description'=>Schema::TYPE_TEXT,
                'meta_key'=>Schema::TYPE_TEXT,
                'meta_description'=>Schema::TYPE_TEXT

            ]);

    }

    public function down()
    {
        $this->dropTable('{{%category}}');
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
