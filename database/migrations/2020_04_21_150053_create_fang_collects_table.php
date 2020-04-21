<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFangCollectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fang_collects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid',255)->comment('用户唯一id');
            $table->unsignedInteger('fang_id')->default(0)->comment('收藏的房源id');
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
        Schema::dropIfExists('fang_collects');
    }
}
