<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmapRegionBoundaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amap_region_boundary', function (Blueprint $table) {
            $table->id();
            $table->string('name', 24)->default('')->comment('区域名称');
            $table->unsignedInteger('code')->default(0)->comment('区域code(adcode)');
            $table->unsignedInteger('pCode')->default(0)->comment('父级code(adcode)');
            $table->unsignedTinyInteger('level')->default(0)->comment('1-province 2-city 3-district 4-street');
            $table->unsignedInteger('cityCode')->default(0)->comment('cityCode');
            $table->decimal('centerLat', 8, 6)->default(0)->comment('中心纬度');
            $table->decimal('centerLng', 9, 6)->default(0)->comment('中心经度');
            $table->json('boundary')->nullable()->comment('边界');
            $table->unsignedInteger('version')->default(0)->comment('版本记录');
            $table->unsignedInteger('createdAt')->default(0)->comment('创建时间');
            $table->unsignedInteger('updatedAt')->default(0)->comment('更新时间');

            $table->index(['level', 'code'], 'idx_levelCode');

            $table->index('pCode', 'idx_pCode');
        });

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `amap_region_boundary` COMMENT '高德行政区域边界表（定时更新）'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amap_region_boundary');
    }
}
