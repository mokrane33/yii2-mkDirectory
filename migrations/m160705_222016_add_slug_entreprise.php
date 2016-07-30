<?php

use yii\db\Migration;

class m160705_222016_add_slug_entreprise extends Migration
{
    public function up()
    {
        $this->addColumn('{{%entreprise}}','slug','string UNIQUE');

    }

    public function down()
    {
        $this->dropColumn('{{%entreprise}}','slug');
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
