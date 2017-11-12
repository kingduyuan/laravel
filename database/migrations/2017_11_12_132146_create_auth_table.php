<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Config;

class CreateAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $rolesTable          = Config::get('entrust.roles_table');
        $roleUserTable       = Config::get('entrust.role_user_table');
        $permissionsTable    = Config::get('entrust.permissions_table');
        $permissionRoleTable = Config::get('entrust.permission_role_table');
        $userModel = Config::get('auth.providers.admins.model');
        $userModel = new $userModel;
        $userKeyName = $userModel->getKeyName();
        $usersTable  = $userModel->getTable();

        // Create table for storing roles
        Schema::create($rolesTable, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create($roleUserTable, function (Blueprint $table) use ($userKeyName, $rolesTable, $usersTable) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('user_id')->references($userKeyName)->on($usersTable)
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on($rolesTable)
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });

        // Create table for storing permissions
        Schema::create($permissionsTable, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create($permissionRoleTable, function (Blueprint $table) use ($permissionsTable, $rolesTable) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on($permissionsTable)
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on($rolesTable)
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $rolesTable          = Config::get('entrust.roles_table');
        $roleUserTable       = Config::get('entrust.role_user_table');
        $permissionsTable    = Config::get('entrust.permissions_table');
        $permissionRoleTable = Config::get('entrust.permission_role_table');
        Schema::drop($permissionRoleTable);
        Schema::drop($permissionsTable);
        Schema::drop($roleUserTable);
        Schema::drop($rolesTable);
    }
}
