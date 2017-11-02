<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUploadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('uploads', function(Blueprint $table)
		{
			$table->increments('id')->comment('Id');
			$table->string('title', 250)->comment('标题');
			$table->string('name', 250)->default('')->comment('名称');
			$table->string('url')->comment('文件访问地址');
			$table->string('path', 250)->comment('路径');
			$table->string('extension', 20)->comment('文件类型');
			$table->boolean('public')->default(1);
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
		Schema::drop('uploads');
	}

}
