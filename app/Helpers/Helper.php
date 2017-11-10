<?php

namespace App\Helpers;

use Closure;

/**
 * Class Helper 助手类
 * @package App\Helpers
 */
class Helper
{
    /**
     * 处理查询参数信息
     *
     * @param \Illuminate\Database\Query\Builder $query 查询对象
     * @param array $params 查询参数
     * @param array $where 查询的配置信息
     */
    public static function handleWhere($query, $params, $where)
    {
        // 第一步：验证参数不能为空
        if (empty($params) || empty($where)) {
            return;
        }

        // 处理查询
        foreach ($where as $column => $value) {
            if (!isset($params[$column]) || $params[$column] === '') {
                continue;
            }

            if ($value instanceof Closure) {
                $value($query, $column, $params[$column]);
            } else {
                if (is_array($value)) {
                    $column = isset($value['column']) ? $value['column'] : $column;
                    $operator = isset($value['operator']) ? $value['operator'] : '=';
                    if (
                        isset($value['callback']) &&
                        (function_exists($value['callback']) || $value['callback'] instanceof Closure)
                    ) {
                        $params[$column] = $value['callback']($params[$column]);
                    }
                } else {
                    $operator = (string)$value;
                }

                self::handleMethod($query, $column, $operator, $params[$column]);
            }
        }
    }

    /**
     * 处理查询的方式
     *
     * @param \Illuminate\Database\Query\Builder $query 查询对象
     * @param string $column 查询字段
     * @param string $operator 连接操作符
     * @param mixed $value 查询的值
     */
    public static function handleMethod($query, $column, $operator, $value)
    {
        switch (strtolower($operator)) {
            case 'in':
            case 'not in':
            case 'between':
            case 'not between':
                $methods = explode(' ', $operator);
                foreach ($methods as &$val) $val = ucfirst($val);
                unset($val);
                $strMethod = 'where' . implode('', $methods);
                $query->{$strMethod}($column, $value);
                break;
            case 'like':
            case 'not like':
                $query->where($column, $operator, '%' . (string)$value . '%');
                break;
            default:
                $query->where($column, $operator, $value);
        }
    }

}