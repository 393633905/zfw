<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->default('')->comment('节点名称');
            $table->string('route_name',50)->nullable()->default('')->comment('路由名称，权限标识');
            $table->unsignedInteger('pid')->default(0)->comment('父级节点id，0表示默认为顶级节点');
            $table->unsignedTinyInteger('is_menu')->default(0)->comment('是否是菜单，0表示否，1表示是');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nodes');
    }
}
