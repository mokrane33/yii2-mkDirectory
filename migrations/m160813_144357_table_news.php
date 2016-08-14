<?php

use yii\db\Migration;

class m160813_144357_table_news extends Migration
{
    public function up()
    {
        $this->createTable('{{%lyxeo_news}}',
            [
            'id'=>$this->primaryKey(),
            'title'=>$this->string(),
            'text_intro'=>$this->text(),
            'text_full'=>$this->text(),
            'slug'=>$this->string(),
            'image'=>$this->string(),
            'created'=>$this->date(),
            'updated'=>$this->date(),
            'status'=>$this->boolean(),
            'order'=>$this->integer(),
            'created_by'=>$this->integer()
        ]
        );

        $this->addForeignKey('news_user_fkey','{{%lyxeo_news}}','created_by','user','id','CASCADE','CASCADE');
    }

    public function down()
    {
        $this->addForeignKey('news_user_fkey','{{%lyxeo_news}}','created_by','user','id','CASCADE','CASCADE');
        $this->dropTable('{{%lyxeo_news}}');
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
