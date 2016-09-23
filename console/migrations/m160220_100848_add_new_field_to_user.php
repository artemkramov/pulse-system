<?php

use yii\db\Migration;

class m160220_100848_add_new_field_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'logo', \yii\db\Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'logo');
    }
}
