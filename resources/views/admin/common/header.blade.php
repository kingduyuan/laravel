<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{ trans('admin.projectName') }} @yield('title') </title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Bootstrap 3.3.4 -->
<link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/css/bootstrap.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/css/font-awesome.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/css/ionicons.min.css') }}"/>
@stack('style')
<!-- Theme style -->
<link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/css/AdminLTE.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/css/skins/skin-white.css') }}"/>
<!--[if lt IE 9]>
<script type="text/javascript" src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script type="text/javascript" src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/plugins/nprogress/nprogress.css') }}"/>