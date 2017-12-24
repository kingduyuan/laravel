@extends("admin.layouts.admin")

@section('header_title', '管理员信息')
@section('header_description', '管理员列表')
@section('header_right')
    <button id="create" class="btn btn-success btn-sm pull-right"> {{ trans('admin.create') }} </button>
@endsection

@section("main-content")
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12" style="margin-bottom: 20px;">
                            <form class="form-inline" id="searchForm" name="searchForm">
                                <div class="form-group">
                                    <label for="inputSearchName">管理员名称</label>
                                    <input type="text" name="name" class="form-control" id="inputSearchName"
                                           placeholder="名称">
                                </div>
                                <div class="form-group">
                                    <label for="inputSearchUrl">管理员邮箱</label>
                                    <input type="email" name="email" class="form-control" id="inputSearchUrl"
                                           placeholder="邮箱">
                                </div>
                                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i>搜索</button>
                            </form>
                        </div>
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover"></table>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

    <!--隐藏的编辑表单-->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"> 编辑角色信息 </h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="updateForm" class="form-horizontal" name="updateForm" action="update">
                        <input type="hidden" name="id" value=""/>
                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-name"> 管理员名称 </label>
                                <div class="col-sm-9">
                                    <input type="text" id="input-name" required="true" rangelength="[2, 50]"
                                           name="name" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-email"> 管理员邮箱 </label>
                                <div class="col-sm-9">
                                    <input type="email" id="input-email" required="true" email="true"
                                           rangelength="[1, 255]"
                                           name="email" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-icon"> 管理员密码 </label>
                                <div class="col-sm-9">
                                    <input type="password" id="input-password" rangelength="[6, 20]"
                                           name="password" class="form-control"/>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary btn-image" id="updateFormSubmit">确定</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin-assets/plugins/datatables/DataTables-1.10.12/css/dataTables.bootstrap.min.css') }}"/>
    <style>
        div.table-page div {
            float: left;
        }

        div.dataTables_length {
            margin-right: 5px;
            line-height: 35px;
        }
    </style>
@endpush
@push("script")
    <script src="{{ asset('admin-assets/plugins/datatables/DataTables-1.10.12/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables/DataTables-1.10.12/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/table/table.js') }}"></script>
    <!-- Page specific script -->
    <script>
        function handleOperator(td, data, rowData, row) {
            var html = "<button class='btn btn-info btn-xs example2-update' data-index=\"" + rowData["id"] + "\" data-row=\"" + row + "\"><i class='fa fa-edit'></i></button> ";
            html += "<button class='btn btn-danger btn-xs example2-delete' data-index=\"" + rowData["id"] + "\" data-row=\"" + row + "\"><i class='fa fa-trash'></i></button> ";
            // html += "<a class='btn btn-info btn-xs' href=\"{{ url('admin/roles/permissions') }}/" + rowData["id"] + "\" data-index=\"" + rowData["id"] + "\" data-row=\"" + row + "\"><i class='fa fa-leaf'></i> 分配角色</a> ";
            $(td).html(html);
        }

        var arrStatus = @json($status, 320),
            arrColors = {"10": "label-success", "0": "label-warning", "-1": "label-danger"};

        $(function () {
            var meTable = meTables({
                sTable: "#example2",
                table: {
                    dom: "t<'row'<'table-page col-sm-4'li><'col-sm-8'p>>",
                    columns: [
                        {
                            "title": "ID", "data": "id", "defaultOrder": "asc", "edit": {type: "hidden"}
                        },
                        {
                            "title": "管理员名称", "data": "name", "orderable": false, "edit": {
                                required: "true", rangelength: "[2, 50]"
                            }
                        },
                        {
                            "title": "管理员邮箱", "data": "email", "orderable": false, "edit": {
                                required: "true", rangelength: "[2, 100]", email: true
                            }
                        },
                        {
                            "title": "管理员密码", "data": "password", "orderable": false, hide: true,
                            "edit": {
                                type: "password", required: "true", rangelength: "[6, 20]"
                            }
                        },
                        {"title": "管理员头像", "data": "avatar", "name": "avatar", "orderable": false},
                        {
                            "title": "状态", "data": "status", "orderable": false,
                            "render": function (data) {
                                return '<span class="label ' + getValue(arrColors, data, 'label-info') + '">' + getValue(arrStatus, data, data) + '</span>';
                            },
                            value: arrStatus,
                            edit: {type: "radio", "default": 10, "required": true, "number": true}
                        },
                        {"title": "创建时间", "data": "created_at"},
                        {"title": "修改时间", "data": "updated_at"},
                        {
                            "title": "操作", "data": null, "orderable": false,
                            "createdCell": handleOperator
                        }
                    ]
                }

            });

            // 表单新增
            $("#create").click(function (e) {
                e.preventDefault();
                meTable.create();
            });
        })
    </script>
@endpush