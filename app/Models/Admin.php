<?php

namespace App\Models;

/**
 * Class Admin
 * @package App\Models
 */
class Admin extends \Illuminate\Foundation\Auth\User
{
    /**
     * 开启状态
     */
    const STATUS_ENABLES = 10;

    /**
     * 停用状态
     */
    const STATUS_DISABLES = 0;

    /**
     * 删除状态
     */
    const STATUS_DELETE = -1;

    /**
     * @var string 定义表名字
     */
    protected $table = 'admins';

    /**
     * @var array 批量赋值的黑名单
     */
    protected $guarded = [];

}
