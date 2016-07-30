<?php

use yii\db\Migration;
use yii\db\Schema;

class m160405_044605_entreprise_produit_create extends Migration
{
    public function up()
    {
        $this->createTable('{{%entr_produit}}',
            [
                'id'=>Schema::TYPE_PK,
                'id_ent'=>Schema::TYPE_INTEGER,
                'title'=>Schema::TYPE_STRING,
                'description'=>Schema::TYPE_TEXT
            ]);

        $this->createTable('{{%entr_produit_image}}',
            [
                'id'=>Schema::TYPE_PK,
                'id_prod'=>Schema::TYPE_INTEGER,
                'image'=>Schema::TYPE_STRING,
                'default'=>Schema::TYPE_BOOLEAN,
            ]);

        $this->addForeignKey('entr_produit_produit_imagefkey','{{%entr_produit_image}}','id_prod','{{%entr_produit}}', 'id','CASCADE','CASCADE');
        $this->addForeignKey('entre_entr_produit_fkey','{{%entr_produit}}', 'id_ent','{{%entreprise}}','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropForeignKey('entr_produit_produit_imagefkey','{{%entr_produit_image}}');
        $this->dropForeignKey('entre_entr_produit_fkey','{{%entr_produit}}');
        $this->dropTable('{{%entr_produit}}');
        $this->dropTable('{{%entr_produit_image}}');
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
