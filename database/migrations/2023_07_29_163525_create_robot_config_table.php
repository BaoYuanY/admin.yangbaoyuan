<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRobotConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('robot_config', function (Blueprint $table) {
            $table->id();
            $table->string('name', 25)->default('Robot')->comment('名称');
            $table->tinyInteger('type')->default(0)->comment('类型');
            $table->tinyInteger('platform')->default(0)->comment('平台');
            $table->string('url', 255)->default('')->comment('链接');
            $table->string('token', 120)->default('')->comment('token');
            $table->string('secret', 120)->default('')->comment('secret');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `robot_config` COMMENT '机器人配置表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('robot_config');
    }
}
