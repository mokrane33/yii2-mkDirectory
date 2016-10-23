<?php

use yii\db\Migration;
use yii\db\Schema;

class m160405_040110_entreprise_create extends Migration
{
    public function up()
    {
        $this->createTable('{{%entreprise}}',
            [
                'id'=>Schema::TYPE_PK,
                'created'=>Schema::TYPE_DATE,
                'modified'=>Schema::TYPE_DATE,
                'status'=>Schema::TYPE_BOOLEAN,
                'image'=>Schema::TYPE_STRING,
                'raisonsociale'=>Schema::TYPE_STRING,
                'description_small'=>Schema::TYPE_TEXT,
                'description_big'=>Schema::TYPE_TEXT,
            ]);

        $this->createTable('{{%entr_cat}}',
            [
                'id'=>Schema::TYPE_PK,
                'id_cat'=>Schema::TYPE_INTEGER,
                'id_ent'=>Schema::TYPE_INTEGER,
            ]);
        $this->createTable('{{%entr_annex}}',
            [
                'id'=>Schema::TYPE_PK,
                'id_ent'=>Schema::TYPE_INTEGER,

            ]);

        $this->createTable('{{%entr_adresse}}',
            [
                'id'=>Schema::TYPE_PK,
                'type_ent'=>Schema::TYPE_INTEGER,
                'id_ent'=>Schema::TYPE_INTEGER,
                'ville'=>Schema::TYPE_INTEGER,
                'adresss'=>Schema::TYPE_STRING,
                'longitude'=>Schema::TYPE_FLOAT,
                'latitude'=>Schema::TYPE_FLOAT

            ]);

        $this->createTable('{{%entr_cont}}',
            [
                'id'=>Schema::TYPE_PK,
                'type_ent'=>Schema::TYPE_INTEGER,
                'id_ent'=>Schema::TYPE_INTEGER,
                'type'=>Schema::TYPE_INTEGER,
                'valeur'=>Schema::TYPE_STRING,
            ]);


        $this->addForeignKey('entre_entr_annex_fkey','{{%entr_annex}}','id_ent','{{%entreprise}}','id','CASCADE','CASCADE');
        $this->addForeignKey('entre_entr_car_fkey','{{%entr_cat}}','id_ent','{{%entreprise}}','id','CASCADE','CASCADE');
        $this->addForeignKey('cat_entr_car_fkey','{{%entr_cat}}','id_cat','{{%category}}','id','CASCADE','CASCADE');

    }

    public function down()
    {
        $this->dropForeignKey('entre_entr_annex_fkey','{{%entr_annex}}');
        $this->dropForeignKey('entre_entr_car_fkey','{{%entr_cat}}');
        $this->dropForeignKey('cat_entr_car_fkey','{{%entr_cat}}');
        $this->dropTable('{{%entreprise}}');
        $this->dropTable('{{%entr_cat}}');
        $this->dropTable('{{%entr_annex}}');
        $this->dropTable('{{%entr_adresse}}');
        $this->dropTable('{{%entr_cont}}');
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
