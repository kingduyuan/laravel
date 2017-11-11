<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Menu
 *
 * @package App\Models
 * @property integer $id
 * @property integer $parent
 * @property integer $status
 */
class Menu extends Model
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
    protected $table = 'menus';

    /**
     * @var array 批量赋值的黑名单
     */
    protected $guarded = [];

    /**
     * 获取状态信息
     *
     * @param null $intStatus 状态值
     * @return array|mixed
     */
    public static function getStatus($intStatus = null)
    {
        $mixReturn = [
            self::STATUS_ENABLES => '启用',
            self::STATUS_DISABLES => '停用',
            self::STATUS_DELETE => '删除',
        ];

        if ($intStatus !== null) $mixReturn = isset($mixReturn[$intStatus]) ? $mixReturn[$intStatus] : null;

        return $mixReturn;
    }

    /**
     * 获取权限对应的导航栏目信息
     *
     * @return array
     */
    public static function getPermissionMenus()
    {
        // 查询数据
        $arrReturn = [];
        $all = self::where('status', '=', self::STATUS_ENABLES)
            ->select('id', 'name', 'url', 'icon', 'parent', 'sort')->get();
        if ($all) {
            foreach ($all as $value) {
                /* @var $value \App\Models\Menu */
                $arrValue = $value->toArray();
                if ($value->parent == 0) {
                    $default = isset($arrReturn[$value->id]) ? $arrReturn[$value->id] : ['child' => []];
                    $arrReturn[$value->id] = array_merge($default, $arrValue);
                } else {
                    if (isset($arrReturn[$value->parent])) {
                        $arrReturn[$value->parent]['child'][] = $arrValue;
                    } else {
                        $arrReturn[$value->parent] = ['child' => [$arrValue]];
                    }
                }
            }
        }

        return $arrReturn;
    }
}
