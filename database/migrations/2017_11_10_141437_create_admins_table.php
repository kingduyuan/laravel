<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admins', function(Blueprint $table)
		{
			$table->increments('id')->comment('唯一ID');
			$table->string('name', 191)->default('')->comment('管理员名称');
			$table->string('email', 191)->unique('users_email_unique')->comment('管理员邮箱');
			$table->string('avatar')->default('')->comment('管理员头像');
			$table->string('password', 191)->comment('管理员密码');
			$table->string('remember_token', 100)->nullable()->comment('记住登陆密码');
			$table->boolean('status')->default(10)->comment('管理员状态【10 启用 0 停用 -1 删除】');
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
		Schema::drop('admins');
	}

}
