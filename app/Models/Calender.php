<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calender extends Model
{
    /**
     * @var string 定义表名字
     */
    protected $table = 'calendars';

    /**
     * @var array 批量赋值的黑名单
     */
    protected $guarded = [];
}
