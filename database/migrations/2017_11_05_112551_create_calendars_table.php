<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCalendarsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('calendars', function(Blueprint $table)
		{
			$table->integer('id', true)->comment('记录ID');
			$table->string('title', 100)->default('')->comment('事件标题');
			$table->string('desc')->nullable()->default('')->comment('事件描述');
			$table->smallInteger('status')->default(0)->comment('状态[0 - 待处理 1 - 已委派 2 - 完成 3 延期]');
			$table->smallInteger('time_status')->default(0)->comment('事件状态[0 - 延缓 1 - 正常 2 - 紧急]');
			$table->dateTime('start')->nullable()->comment('开始时间');
			$table->dateTime('end')->nullable()->comment('结束时间');
			$table->integer('admin_id')->default(0)->comment('委派管理员');
			$table->string('style')->default('')->comment('使用样式');
			$table->timestamps();
			$table->integer('created_id')->default(0)->comment('创建用户');
			$table->integer('updated_id')->default(0)->comment('修改用户');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('calendars');
	}

}
