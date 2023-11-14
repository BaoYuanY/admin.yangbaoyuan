<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 64)->default('')->comment('书籍名称');
            $table->string('anther', 32)->default('')->comment('作者');
            $table->unsignedInteger('totalPage')->default(0)->comment('总页数');
            $table->unsignedInteger('readPage')->default(0)->comment('已读页数');
            $table->unsignedTinyInteger('source')->default(0)->comment('0-默认 1-纸质 2-neatReader 3-阿里云盘 4-百度网盘 5-Apple 6-BookChat');
            $table->string('type', 12)->default('')->comment('类型 纸质/PDF/EPUB/MOBI');
            $table->string('publisher', 64)->default('')->comment('出版社');
            $table->string('coverUrl', 64)->default('')->comment('书籍封面图片 URL');
            $table->text('summary')->nullable()->comment('书籍简介');
            $table->unsignedInteger('publishDate')->default(0)->comment('出版日期');
            $table->unsignedTinyInteger('version')->default(0)->comment('版本');
            $table->string('language', 32)->default('中文')->comment('原始语言');
            $table->string('category')->default('')->comment('分类');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->unsignedInteger('createdAt')->default(0)->comment('创建时间');
            $table->unsignedInteger('updatedAt')->default(0)->comment('修改时间');
            $table->collation = 'utf8mb4_general_ci';
            $table->comment = '书籍';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
