@extends("admin.layouts.admin")

@section('header_title', '导航管理')
@section('header_description', '导航栏目列表')
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
                                    <label class="sr-only" for="inputSearchName">名称</label>
                                    <input type="text" name="name" class="form-control" id="inputSearchName"
                                           placeholder="导航名称">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="inputSearchUrl">地址</label>
                                    <input type="text" name="url" class="form-control" id="inputSearchUrl"
                                           placeholder="导航地址">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="inputSearchPermissionName">权限名称</label>
                                    <input type="text" name="permission_name" class="form-control"
                                           id="inputSearchPermissionName" placeholder="权限名称">
                                </div>
                                <div class="form-group" style="min-width:200px;">
                                    <select class="form-control select2 pull-left" name="status[]" multiple="multiple"
                                            id="inputSearchStatus" data-placeholder="选择状态" style="width: 100%;">
                                        @foreach($status as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
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
                    <h4 class="modal-title"> 编辑导航栏目信息 </h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="updateForm" class="form-horizontal" name="updateForm" action="update">
                        <input type="hidden" name="id" value=""/>
                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-name"> 导航栏目名称 </label>
                                <div class="col-sm-9">
                                    <input type="text" id="input-name" required="true" rangelength="[2, 50]"
                                           name="name" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-url"> 导航栏目地址 </label>
                                <div class="col-sm-9">
                                    <input type="text" id="input-url" required="true" rangelength="[1, 255]"
                                           name="url" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-icon"> 导航栏目图标 </label>
                                <div class="col-sm-9">
                                    <input type="text" id="input-icon" required="true" value="fa-cube"
                                           rangelength="[2, 255]"
                                           name="icon" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="inputParent"> 父级分类 </label>
                                <div class="col-sm-9">
                                    <select name="parent" id="inputParent" class="form-control">
                                        <option value="0">顶级分类</option>
                                        @foreach($parents as $key => $value)
                                            <option value="{{ $key }}"> {{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"> 状态 </label>
                                <div class="col-sm-9">
                                    @foreach($status as $key => $value)
                                        <label>
                                            <input type="radio" required="true" number="true" name="status"
                                                   @if ($key == 1)
                                                   checked="checked"
                                                   @endif
                                                   class="minimal" value="{{ $key }}">
                                            {{ $value }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-sort"> 排序 </label>
                                <div class="col-sm-9">
                                    <input type="text" id="input-name" required="true" number="true"
                                           name="sort" class="form-control"/>
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
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin-assets/plugins/select2/select2.min.css') }}"/>
@endpush
@push("script")
    <script src="{{ asset('admin-assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables/DataTables-1.10.12/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables/DataTables-1.10.12/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/select2/select2.min.js') }}"></script>
    <!-- Page specific script -->
    <script>
        $(function () {

            $(".select2").select2();

            var arrParents = @json($parents, 320),
                arrStatus = @json($status, 320),
                arrColors = {"10": "label-success", "0": "label-warning", "-1": "label-danger"};
            var meTable = $('#example2').DataTable({
                "dom": "t<'row'<'col-xs-6'li><'col-xs-6'p>>",
                'paging': true,
//                'lengthChange': false,
                "lengthMenu": [15, 30, 50, 100],
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "{{ url('/admin/menus/search') }}",
                    data: function (d) {
                        d.where = $("#searchForm").serialize();
                        return d;
                    }
                },
                language: jqueryDataTableLanguage,
                columns: [
                    {"title": "id", "data": "id"},
                    {"title": "名称", "data": "name", "orderable": false},
                    {"title": "地址", "data": "url", "orderable": false},
                    {
                        "title": "图标", "data": "icon", "orderable": false, "render": function (data) {
                        return data ? "<i class=\"fa " + data + "\"></i>" : data;
                    }
                    },
                    {
                        "title": "父级名称", "data": "parent", "render": function (data) {
                        return arrParents[data] ? arrParents[data] : "顶级分类";
                    }
                    },
                    {
                        "title": "状态", "data": "status", "render": function (data) {
                        return '<span class="label ' + getValue(arrColors, data, 'label-info') + '">' + getValue(arrStatus, data, data) + '</span>';
                    }
                    },
                    {"title": "排序", "data": "sort", "name": "sort"},
                    {"title": "创建时间", "data": "created_at"},
                    {"title": "修改时间", "data": "updated_at"},
                    {
                        "title": "操作", "data": null, "orderable": false,
                        "createdCell": function (td, data, rowData, row, col) {
                            $(td).html("<button class='btn btn-info btn-xs table-update' data-index=\"" + rowData["id"] + "\" data-row=\"" + row + "\"><i class='fa fa-edit'></i></button>");
                        }
                    }
                ]
            });

            // 表单搜索
            $("#searchForm").submit(function (e) {
                e.preventDefault();
                meTable.ajax.reload();
                return false;
            });

            // 表单编辑
            $(document).on("click", "button.table-update", function(e){
                e.preventDefault();
                var id = $(this).attr("data-index"), row = $(this).attr("data-row");
                initForm("#updateForm", meTable.data()[row]);
                $("#updateForm").prop("action", "{{ url('/admin/menus/update') }}");
                $("#updateModal").modal();
            });

            // 表单新增
            $("#create").click(function(e){
                e.preventDefault();
                initForm("#updateForm", null);
                $("#updateForm").prop("action", "{{ url('/admin/menus/create') }}");
                $("#updateModal").modal();
            });

            // 表单编辑
            $("#updateFormSubmit").click(function(e){
                e.preventDefault();
                var $fm = $("#updateForm");
                if ($fm.validate().form()) {
                    getLaravelRequest({
                        url: $fm.prop("action"),
                        data: $fm.serialize(),
                        dataType: "json",
                        type: "POST"
                    }).done(function(json){
                        layer.msg(json.message, {icon: json.code === 0 ? 6 : 5, time: 500});
                        if (json.code === 0) {
                            $("#updateModal").modal("hide");
                            meTable.ajax.reload();
                        }
                    });
                }

                return false;
            });
        })
    </script>
@endpush