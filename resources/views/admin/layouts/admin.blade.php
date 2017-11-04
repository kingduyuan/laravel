<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Uploaded images & files - LaraAdmin 1.0</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 3.3.4 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/css/bootstrap.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/css/ionicons.min.css') }}"/>
    <!-- Theme style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/css/AdminLTE.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/css/skins/skin-white.css') }}"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script type="text/javascript" src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @stack('style')
</head>
<body class="skin-white fixed ">
<div class="wrapper">
    <!-- Main Header -->
    <header class="main-header">
        <!-- Logo -->
        <a href="{{ route('admin.index')  }}" class="logo">
            <span class="logo-mini"><b>Laravel</b></span>
            <span class="logo-lg"><b>Laravel</b>
		    Admin 1.0</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle b-l" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <!-- inner menu: contains the messages -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <!-- User Image -->
                                                <img src=" http://www.gravatar.com/avatar/77eddd4a460eb5af5db6b7911926f7f5.jpg?s=80&amp;d=mm&amp;r=g "
                                                     class="img-circle" alt="User Image"/>
                                            </div>
                                            <!-- Message title and timestamp -->
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <!-- The message -->
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li><!-- end message -->
                                </ul><!-- /.menu -->
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li><!-- /.messages-menu -->
                    <!-- Notifications Menu -->
                    <li class="dropdown notifications-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <!-- Inner Menu: contains the notifications -->
                                <ul class="menu">
                                    <li><!-- start notification -->
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li><!-- end notification -->
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <!-- Tasks Menu -->
                    <li class="dropdown tasks-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <!-- Inner menu: contains the tasks -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <!-- Task title and progress text -->
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <!-- The progress bar -->
                                            <div class="progress xs">
                                                <!-- Change the css width attribute to simulate progress -->
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li><!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="http://www.gravatar.com/avatar/77eddd4a460eb5af5db6b7911926f7f5.jpg?s=80&amp;d=mm&amp;r=g"
                                 class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">admin</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="http://www.gravatar.com/avatar/77eddd4a460eb5af5db6b7911926f7f5.jpg?s=80&amp;d=mm&amp;r=g"
                                     class="img-circle" alt="User Image"/>
                                <p>
                                    admin
                                    <small>Member since Nov. 2017</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="col-xs-6 text-center mb10">
                                    <a href="http://laravel-admin.com/admin/lacodeeditor"><i class="fa fa-code"></i>
                                        <span>Editor</span></a>
                                </div>
                                <div class="col-xs-6 text-center mb10">
                                    <a href="http://laravel-admin.com/admin/modules"><i class="fa fa-cubes"></i> <span>Modules</span></a>
                                </div>
                                <div class="col-xs-6 text-center mb10">
                                    <a href="http://laravel-admin.com/admin/la_menus"><i class="fa fa-bars"></i> <span>Menus</span></a>
                                </div>
                                <div class="col-xs-6 text-center mb10">
                                    <a href="http://laravel-admin.com/admin/la_configs"><i class="fa fa-cogs"></i>
                                        <span>Configure</span></a>
                                </div>
                                <div class="col-xs-6 text-center">
                                    <a href="http://laravel-admin.com/admin/backups"><i class="fa fa-hdd-o"></i> <span>Backups</span></a>
                                </div>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="http://laravel-admin.com/admin/users/1" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="http://laravel-admin.com/logout" class="btn btn-default btn-flat">Sign
                                        out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-comments-o"></i> <span
                                    class="label label-warning">10</span></a>

                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="http://www.gravatar.com/avatar/77eddd4a460eb5af5db6b7911926f7f5.jpg?s=80&amp;d=mm&amp;r=g"
                         class="img-circle" alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p> admin </p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('admin.online') }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            @include('admin.layouts.menu')
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> @yield('header_title', trans('admin.welcome'))
                <small> @yield('header_description') </small>
            </h1>
            @hasSection('header_right')
                <span class="headerElems pull-right">
                    @yield('header_right')
                </span>
            @else
                <ol class="breadcrumb">
                    <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> {{ trans('admin.home') }} </a></li>
                    @foreach ($breadCrumb as $item)
                        @if ($loop->last)
                            <li class="active">{{ $item['label'] }}</li>
                        @else
                            <li><a href="{{ $item['url'] }}">{{ $item['label']  }}</a></li>
                        @endif
                    @endforeach
                </ol>
            @endif
        </section>
        <!-- Main content -->
        <section class="content ">
            <!-- Your Page Content Here -->
            @yield('main-content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    @include('admin.common.aside')

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            {{ trans('admin.poweredBy') }} <a href="https://github.com/myloveGy"> liujinxing </a>
        </div>
        <strong>Copyright &copy; 2016</strong>
    </footer>
</div>

<!-- jQuery 2.1.4 -->
<script type="text/javascript" src="{{ asset('admin-assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script type="text/javascript" src="{{ asset('admin-assets/js/bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="{{ asset('admin-assets/js/app.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin-assets/plugins/stickytabs/jquery.stickytabs.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin-assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/layer/layer.js') }}"></script>
@stack('script')
</body>
</html>

