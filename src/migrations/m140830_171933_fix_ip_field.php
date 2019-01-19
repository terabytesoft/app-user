<?php

use app\user\migrations\Migration;

class m140830_171933_fix_ip_field extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%user}}', 'registration_ip', $this->bigInteger());
    }

    public function down()
    {
        $this->alterColumn('{{%user}}', 'registration_ip', $this->integer());
    }
}
