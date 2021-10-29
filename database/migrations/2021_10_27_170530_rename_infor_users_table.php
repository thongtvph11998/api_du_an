<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameInforUsersTable extends Migration
{

    public function up()
    {
        Schema::rename('info_users', 'infor_users');
    }


    public function down()
    {
        //
    }
}
