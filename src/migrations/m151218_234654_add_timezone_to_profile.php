<?php

use app\user\migrations\Migration;

class m151218_234654_add_timezone_to_profile extends Migration
{
    public function up()
    {
        $this->addColumn('{{%profile}}', 'timezone', $this->string(40)->null());
    }

    public function down()
    {
        $this->dropcolumn('{{%profile}}', 'timezone');
    }
}
