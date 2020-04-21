<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',200)->default('')->comment('文章标题');
            $table->string('desc',500)->default('')->comment('摘要');
            $table->string('pic',100)->default('')->comment('封面图片路径');
            $table->text('content')->comment('文章内容');
            $table->string('url',255)->default('')->comment('文章内容爬取链接');
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
        Schema::dropIfExists('articles');
    }
}
