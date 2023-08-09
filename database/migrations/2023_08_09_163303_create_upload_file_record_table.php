<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadFileRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_file_record', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->default(0)->comment('文件上传平台');
            $table->string('url', 255)->default('')->comment('文件url');
            $table->tinyInteger('isDeleted')->default(0)->comment('是否删除');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `upload_file_record` COMMENT '文件上传记录'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload_file_record');
    }
}
