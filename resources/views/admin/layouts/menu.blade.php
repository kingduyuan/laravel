<?php

?>
<ul class="sidebar-menu">
    <li>
        <a href="{{ url('/admin/index') }}">
            <i class='fa fa-home'></i>
            <span>Dashboard</span></a>
    </li>

    <li class="active"><a href="http://laravel-admin.com/admin/uploads"><i class="fa fa-files-o"></i> <span>Uploads</span>
        </a></li>
    <li><a href="http://laravel-admin.com/admin/organizations"><i class="fa fa-university"></i> <span>Organizations</span>
        </a></li>
    <li class="treeview">
        <a href="http://laravel-admin.com/admin/#">
            <i class="fa fa-group"></i>
            <span>Team</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="http://laravel-admin.com/admin/users"><i class="fa fa-group"></i>
                    <span>Users</span> </a></li>
            <li><a href="http://laravel-admin.com/admin/departments"><i class="fa fa-tags"></i> <span>Departments</span>
                </a></li>
            <li><a href="http://laravel-admin.com/admin/employees"><i class="fa fa-group"></i> <span>Employees</span>
                </a></li>
            <li><a href="http://laravel-admin.com/admin/roles"><i class="fa fa-user-plus"></i>
                    <span>Roles</span> </a></li>
            <li><a href="http://laravel-admin.com/admin/permissions"><i class="fa fa-magic"></i> <span>Permissions</span>
                </a></li>
        </ul>
    </li>
</ul>