<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id')->default(0)->comment('角色id，0表示未分配角色');
            $table->string('username',50)->comment('用户名');
            $table->string('truename',50)->default('未知')->comment('真实姓名');
            $table->string('password',255)->comment('密码');
            $table->string('email',50)->nullable()->comment('邮箱');
            $table->string('mobile',15)->default('')->comment('手机号');
            $table->enum('gender',['先生','女士'])->default('先生')->comment('性别');
            $table->char('last_login_ip',15)->default('')->comment('最后一次登录ip');
            $table->timestamps();
            //软删除：生成delete_at字段
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
        Schema::dropIfExists('users');
    }
}
