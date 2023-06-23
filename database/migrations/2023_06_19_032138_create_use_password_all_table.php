<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsePasswordAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('use_password_all', function (Blueprint $table) {
            $table->id();
            $table->string('platform', 255)->default('')->comment('平台');
            $table->string('account', 255)->default('')->comment('账号');
            $table->string('phone', 15)->default('')->comment('手机');
            $table->string('email', 32)->default('')->comment('邮箱');
            $table->string('password', 255)->default('')->comment('密码');
            $table->string('salt', 32)->default('')->comment('加盐');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('use_password_all');
    }
}
