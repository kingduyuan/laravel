@extends("admin.layouts.admin")

@section('header_title', '日程管理')
@section('header_description', '日程列表')
@section('header_right')
    123
@endsection

@section("main-content")
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
                                       aria-describedby="example2_info">
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1
                                    to 10 of 57 entries
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    <ul class="pagination">
                                        <li class="paginate_button previous disabled" id="example2_previous">
                                            <a href="#"
                                               aria-controls="example2"
                                               data-dt-idx="0"
                                               tabindex="0">Previous</a>
                                        </li>
                                        <li class="paginate_button active"><a href="#" aria-controls="example2"
                                                                              data-dt-idx="1" tabindex="0">1</a></li>
                                        <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="2"
                                                                        tabindex="0">2</a></li>
                                        <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="3"
                                                                        tabindex="0">3</a></li>
                                        <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="4"
                                                                        tabindex="0">4</a></li>
                                        <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="5"
                                                                        tabindex="0">5</a></li>
                                        <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="6"
                                                                        tabindex="0">6</a></li>
                                        <li class="paginate_button next" id="example2_next"><a href="#"
                                                                                               aria-controls="example2"
                                                                                               data-dt-idx="7" tabindex="0">Next</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

    <!--隐藏的编辑表单-->
    <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"> 编辑日程事件信息 </h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="editForm" class="form-horizontal" name="editForm" action="update">
                        <input type="hidden" name="actionType" value="create"/>
                        <input type="hidden" name="id" value=""/>
                        <input type="hidden" name="admin_id" value="1"/>
                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-title"> 事件标题 </label>
                                <div class="col-sm-9">
                                    <input type="text" id="input-title" required="true" rangelength="[2, 100]"
                                           name="title" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="desc"> 事件描述 </label>
                                <div class="col-sm-9">
                                    <textarea required="true" rangelength="[2, 255]" id="desc" name="desc"
                                              class="form-control form-control" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="start_at"> 开始时间 </label>
                                <div class="col-sm-9">
                                    <div class="input-group bootstrap-datetimepicker">
                                        <input type="text" class="form-control datetime-picker me-datetime"
                                               id="start_at" required="true" name="start">
                                        <span class="input-group-addon"><i class="fa fa-clock-o bigger-110"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="end_at"> 结束时间 </label>
                                <div class="col-sm-9">
                                    <div class="input-group bootstrap-datetimepicker">
                                        <input type="text" class="form-control datetime-picker me-datetime" id="end_at"
                                               required="true" name="end">
                                        <span class="input-group-addon">
                                        <i class="fa fa-clock-o bigger-110"></i>
                                    </span>
                                    </div>
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
                                                   @endif;
                                                   class="minimal" value="{{ $key }}">
                                            {{ $value }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"> 时间状态 </label>
                                <div class="col-sm-9">
                                    @foreach($timeStatus as $key => $value)
                                        <label>
                                            <input type="radio" required="true" number="true" name="time_status"
                                                   @if ($key == 1)
                                                   checked="checked"
                                                   @endif;
                                                   class="minimal" value="{{ $key }}">
                                            {{ $value }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    <button class="btn btn-primary btn-flat btn-sm" id="style-button">背景样式</button>
                                </label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="style" value="#3c8dbc" id="style-input">
                                    <ul class="fc-color-picker color-chooser" id="style-select">
                                        <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                                        <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                                        <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                                        <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                                        <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                                        <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                                        <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                                        <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                                        <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                                        <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                                        <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="delete-calendar" data-action="delete">
                        <i class="ace-icon fa fa-trash-o"></i> 删除这个日程事件
                    </button>
                    <button type="button" class="btn btn-sm btn-primary btn-image" id="update-calendar">确定</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin-assets/plugins/fullcalendar/fullcalendar.min.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin-assets/plugins/iCheck/all.css') }}"/>
@endpush
@push("script")
    <script src="{{ asset('admin-assets/plugins/datatables/DataTables-1.10.12/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datatables/DataTables-1.10.12/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- Page specific script -->
    <script>
        $(function () {
            $('#example2').DataTable({
                'paging'      : true,
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false
            })
        })
    </script>
@endpush