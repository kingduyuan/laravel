<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

/**
 * Class DatabaseSeeder
 *
 * 数据库填充数据
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');

        // 添加一个用户
        $intAdminId = DB::table('admins')->insertGetId([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin888'),
            'status' => 10,
            'created_at' => $date,
            'updated_at' => $date
        ]);

        // 添加后台管理导航栏目
        $intParentId = DB::table('menus')->insertGetId([
            'name' => '后台管理', 'url' => '#', 'icon' => 'fa-cogs', 'parent' => 0, 'created_at' => $date, 'updated_at' => $date
        ]);

        DB::table('menus')->insert([
            ['name' => '管理员', 'url' => '/admin/admins/index', 'icon' => 'fa-user', 'parent' => $intParentId, 'created_at' => $date, 'updated_at' => $date],
            ['name' => '导航栏目', 'url' => '/admin/menus/index', 'icon' => 'fa-bars', 'parent' => $intParentId, 'created_at' => $date, 'updated_at' => $date],
            ['name' => '角色管理', 'url' => '/admin/roles/index', 'icon' => 'fa-magic', 'parent' => $intParentId, 'created_at' => $date, 'updated_at' => $date],
            ['name' => '权限管理', 'url' => '/admin/permissions/index', 'icon' => 'fa-leaf', 'parent' => $intParentId, 'created_at' => $date, 'updated_at' => $date],
        ]);

        // 添加导航栏目
        DB::table('menus')->insert([
            ['name' => '日程管理', 'url' => '/admin/calendars/index', 'icon' => 'fa-calendar', 'parent' => 0, 'created_at' => $date, 'updated_at' => $date],
            ['name' => '上传文件', 'url' => '/admin/uploads/index', 'icon' => 'fa-upload', 'parent' => 0, 'created_at' => $date, 'updated_at' => $date],

        ]);

        // 添加权限
        DB::table(Config::get('entrust.permissions_table'))->insert([
            ['name' => 'admin.menus.index', 'display_name' => '/admin/menus/index', 'description' => '导航栏目-显示数据', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'admin.menus.search', 'display_name' => '/admin/menus/search', 'description' => '导航栏目-搜索数据', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'admin.menus.create', 'display_name' => '/admin/menus/create', 'description' => '导航栏目-创建数据', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'admin.menus.update', 'display_name' => '/admin/menus/update', 'description' => '导航栏目-修改数据', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'admin.menus.delete', 'display_name' => '/admin/menus/delete', 'description' => '导航栏目-删除数据', 'created_at' => $date, 'updated_at' => $date],
        ]);

        // 添加角色
        $intRoleId = DB::table(Config::get('entrust.roles_table'))->insert([
            'name' => 'superAdmin', 'display_name' => '超级管理员', 'description' => '超级管理员', 'created_at' => $date, 'updated_at' => $date
        ]);

        DB::table(Config::get('entrust.roles_table'))->insert([
            ['name' => 'admin', 'display_name' => '普通管理员', 'description' => '普通管理员', 'created_at' => $date, 'updated_at' => $date],
        ]);

        // 角色分配权限
        $results = DB::select('SELECT `id` FROM ' . Config::get('entrust.permissions_table'));
        foreach ($results as $value) {
            DB::table(Config::get('entrust.permission_role_table'))->insert([
                ['role_id' => $intRoleId, 'permission_id' => $value->id],
            ]);
        }

        // 管理员分配角色
        DB::table(Config::get('entrust.role_user_table'))->insert(['user_id' => $intAdminId, 'role_id' => $intRoleId]);
    }
}
