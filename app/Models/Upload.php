<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Uploads 上传文件表
 * @package App\Models
 */
class Upload extends Model
{
    /**
     * @var string 定义表名字
     */
    protected $table = 'uploads';

    /**
     * @var array 批量赋值的黑名单
     */
    protected $guarded = [];
}
