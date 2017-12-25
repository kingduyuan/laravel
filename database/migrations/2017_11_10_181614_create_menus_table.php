<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus', function(Blueprint $table)
		{
			$table->increments('id')->comment('导航栏目ID');
			$table->string('name', 50)->comment('导航栏目名称');
			$table->string('url', 256)->comment('导航的地址');
			$table->string('icon', 50)->default('fa-cube')->comment('使用的图标');
			$table->integer('parent')->unsigned()->default(0)->comment('父级ID');
			$table->boolean('status')->default(10)->comment('状态 10 启用 0 停用 -1 删除');
			$table->smallInteger('sort')->default(100)->comment('排序');
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
		Schema::drop('menus');
	}

}
