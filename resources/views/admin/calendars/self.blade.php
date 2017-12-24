@extends("admin.layouts.admin")

@section('header_title', '日程管理')
@section('header_description', '我的日程')
@php
    $breadCrumb = [
        ['label' => '日程管理', 'url' => '/admin/uploads/index'],
        ['label' => '我的日程']
    ];
@endphp
@section("main-content")
    <div class="row">
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">{{ trans('admin.draggableEvents') }}</h4>
                </div>
                <div class="box-body">
                    <!-- the events -->
                    <div id="external-events">
                        @foreach($calendars as $calendar)
                            <div class="external-event"
                                 style="color: #fff; background-color: {{ $calendar->backgroundColor }}; border-color: {{ $calendar->borderColor }}"
                                 data-id="{{ $calendar->id }}"
                                 data-title="{{ $calendar->title }}"
                                 data-desc="{{ $calendar->desc }}"
                                 data-time_status="{{ $calendar->time_status }}"
                            >{{ $calendar->title }}</div>
                        @endforeach
                        <div class="checkbox">
                            <label for="drop-remove">
                                <input type="checkbox" id="drop-remove">
                                {{ trans('admin.removeAfterDrop') }}
                            </label>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('admin.createEvent')  }}</h3>
                </div>
                <div class="box-body">
                    <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                        <ul class="fc-color-picker" id="color-chooser">
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
                    <!-- /btn-group -->
                    <div class="input-group">
                        <input id="new-event" type="text" class="form-control"
                               placeholder="{{ trans('admin.eventTitle') }}">
                        <div class="input-group-btn">
                            <button id="add-new-event" type="button"
                                    class="btn btn-primary btn-flat"> {{ trans('admin.create') }} </button>
                        </div>
                        <!-- /btn-group -->
                    </div>
                    <!-- /input-group -->
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-body no-padding">
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
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
                                                   @endif
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
                                                   @endif
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
    <script src="{{ asset('admin-assets/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datepicker/moment.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- Page specific script -->
    <script>
        /**
         * formObject() 给表单对象赋值
         * @param form   表单对象
         * @param array 用来赋值对象
         */
        function formObject(form, array) {
            form.reset();
            if (array) {
                for (var i in array) {
                    if (form[i]) form[i].value = array[i];
                }
            }
        }

        var modal = $('#calendarModal'),
            oDrop = null,
            calenderCalEvent = {},
            form = document.editForm;

        /**
         * formUpdateObject() 给修改的表单对象赋值，并确定是否提交数据
         * @param form      表单对象
         * @param calEvent  事件对象
         * @param isSubmit  是否提交表单
         */
        function formUpdateObject(form, calEvent, isSubmit) {
            calenderCalEvent = calEvent;
            formObject(form, {
                id: calEvent.id,                                   // ID
                title: $.trim(calEvent.title),                        // 标题
                desc: $.trim(calEvent.desc),                         // 说明描述
                start: calEvent.start.format('YYYY-MM-DD HH:mm:ss'),  // 时间开始
                end: calEvent.end.format('YYYY-MM-DD HH:mm:ss'),    // 时间结束
                time_status: calEvent.time_status,                  // 时间状态
                status: calEvent.status,                               // 状态
                actionType: 'update',
                "style": calEvent.backgroundColor
            });

            $("#style-button").css({
                "background-color": calEvent.backgroundColor,
                "border-color": calEvent.backgroundColor
            });
            $("#style-input").val(calEvent.backgroundColor);
            if (isSubmit === true) $('#update-calendar').trigger('click');
        }

        $(function () {
            // 编辑选择样式
            var $b = $("#style-button"),
                $i = $("#style-input"),
                strColor = '#3c8dbc';
            $("#style-select a").click(function (e) {
                e.preventDefault();
                strColor = $(this).css("color");
                $b.css({"background-color": strColor, "border-color": strColor});
                $i.val(strColor);
            });

            //Red color scheme for iCheck
            $('input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });

            $('#external-events div.external-event').each(function () {
                $(this).draggable({
                    zIndex: 1070,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                })
            });

            // 初始化一个事件管理
            var calendar = $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                buttonText: {
                    today: '{{ trans('admin.today') }}',
                    month: '{{ trans('admin.month') }}',
                    week: '{{ trans('admin.week') }}',
                    day: '{{ trans('admin.day') }}'
                },
                //Random default events
                events: "{{ url('/admin/calendars/events') }}",
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
                drop: function (date, allDay) { // this function is called when something is dropped
                    var isDel = $('#drop-remove').is(':checked');
                    if (isDel) oDrop = $(this);
                    var day = new Date(date.format("YYYY-MM-DD HH:mm:ss")),
                        time = day.getTime() + 24 * 3600 * 1000,
                        endDate = new Date(time);

                    formObject(form, {
                        "id": $.trim($(this).attr("data-id")),
                        "title": $.trim($(this).attr("data-title")),
                        "desc": $.trim($(this).attr("data-desc")),
                        "start": date.format("YYYY-MM-DD HH:mm:ss"),
                        "end": moment(endDate).format("YYYY-MM-DD HH:mm:ss"),
                        "status": 1,
                        "time_status": $.trim($(this).attr("data-time_status")),
                        "actionType": isDel ? "update" : "create",
                        "style": $(this).css("background-color")
                    });

                    $('#update-calendar').trigger("click");
                },

                /**
                 * 事件被拖拽
                 * calEvent      已经移动后的事件对象
                 * dayDelta      保存日程向前或者向后移动了多少的数据
                 * minuteDelta   这个值只有在agenda视图有效，移动的时间
                 * allDay        如果是月视图,或者是agenda视图的全天日程，此值为true,否则为false
                 */
                eventDrop: function (calEvent, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {
//                    // 表单重新赋值
                    formUpdateObject(form, calEvent, true);
                },
                /**
                 * 事件改变大小
                 * calEvent      已经移动后的事件对象
                 * dayDelta      保存日程向前或者向后移动了多少的数据
                 * minuteDelta   这个值只有在agenda视图有效，移动的时间
                 * allDay        如果是月视图,或者是agenda视图的全天日程，此值为true,否则为false
                 */
                eventResize: function (calEvent, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {
                    // 表单重新赋值
                    formUpdateObject(form, calEvent, true);
                },

                selectable: true,
                selectHelper: true,
                // 点击日期事件
                select: function (start, end, allDay) {
                    $('#delete-calendar').hide();
                    // 默认赋值
                    formObject(form, {
                        "id": 0,
                        "start": start.format('YYYY-MM-DD HH:mm:ss'),    // 时间开始
                        'end': end.format('YYYY-MM-DD HH:mm:ss'),       // 时间结束
                        'time_status': 1,                               // 时间状态
                        'status': 1,                                    // 状态
                        'actionType': 'create'                          // 操作类型
                    });

                    // 添加一个新的日程事件
                    modal.modal('show').find('h4').html('添加一个新的事件');
                },

                // 事件被点击
                eventClick: function (calEvent, jsEvent, view) {
                    $('#delete-calendar').show();
                    // 开始赋值显示编辑
                    formUpdateObject(form, calEvent);
                    modal.modal('show').find('h4').html('编辑日程事件信息');
                }
            });

            // 选择颜色联动
            var currColor = '#3c8dbc';
            var $addEvent = $('#add-new-event');
            $('#color-chooser > li > a').click(function (e) {
                e.preventDefault();
                currColor = $(this).css('color');
                $addEvent.css({'background-color': currColor, 'border-color': currColor})
            });

            // 添加新的事件
            $addEvent.click(function (e) {
                e.preventDefault();
                var $events = $('#new-event'),
                    val = $events.val();
                if (val.length === 0) {
                    return
                }

                // 开始新增数据
                getLaravelRequest({
                    url: "{{ url('admin/calendars/create') }}",
                    data: {
                        title: val,
                        style: currColor,
                        status: 0
                    },
                    dataType: "json",
                    type: "POST"
                }).done(function (json) {
                    if (json.code === 0) {
                        //Create events
                        var event = $('<div />');
                        event.css({
                            'background-color': currColor,
                            'border-color': currColor,
                            'color': '#fff'
                        }).addClass('external-event').attr({
                            "data-id": json.data.id,
                            "data-title": json.data.title,
                            "data-desc": json.data.desc,
                            "data-status": 1,
                            "data-time_status": json.data["time_status"],
                            "data-style": currColor
                        });

                        event.html(val).draggable({
                            zIndex: 1070,
                            revert: true, // will cause the event to go back to its
                            revertDuration: 0  //  original position after the drag
                        });

                        $('#external-events').prepend(event);
                        $events.val('')
                    } else {
                        layer.msg(json.message, {icon: 5});
                    }
                });
            });

            // 编辑日程事件
            $('#update-calendar').click(function () {
                var $fm = $('#editForm');
                if ($fm.validate().form()) {
                    // 提交数据
                    getLaravelRequest({
                        url: "/admin/calendars/" + $fm.find('input[name=actionType]').val(),
                        type: "POST",
                        dataType: "json",
                        data: $fm.serializeArray()
                    }).done(function (json) {
                        layer.msg(json.message, {icon: json.code === 0 ? 6 : 5});
                        if (json.code === 0) {
                            var style = "";
                            try {
                                style = JSON.parse(json.data.style);
                                console.info(style);
                            } catch (e) {
                            }

                            // 开始修改数据
                            calenderCalEvent.id = json.data.id;
                            calenderCalEvent.desc = json.data.desc;
                            calenderCalEvent.title = json.data.title;
                            calenderCalEvent.start = new Date(json.data.start);
                            calenderCalEvent.end = new Date(json.data.end);
                            calenderCalEvent.status = json.data.status;
                            calenderCalEvent.time_status = json.data.time_status;
                            // calenderCalEvent.allDay = true; //  json.data.time_status;

                            if (style) {
                                calenderCalEvent.backgroundColor = style.backgroundColor;
                                calenderCalEvent.borderColor = style.borderColor;
                            }

                            // 判断类型处理数据
                            var strEvent = form.actionType.value === "update" && !oDrop ? "updateEvent" : "renderEvent";
                            calendar.fullCalendar(strEvent, calenderCalEvent, true);
                            // 新增日程事件
                            if (strEvent === "renderEvent" && !oDrop) calendar.fullCalendar("unselect");
                            // 拖拽日程事件
                            if (oDrop) oDrop.remove();
                            oDrop = null;
                            calenderCalEvent = {};
                            modal.modal("hide");
                        }
                    });
                }
            });

            // 删除日程事件
            $('#delete-calendar').click(function () {
                // 删除之前先提醒
                layer.confirm('您确定需要删除这条数据吗?', {
                    title: '确认操作',
                    btn: ['确定', '取消'],
                    shift: 4,
                    icon: 0
                    // 确认删除
                }, function () {
                    ajax({
                        url: 'delete',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'id': calenderCalEvent._id,
                        }
                    }).done(function (json) {
                        layer.msg(json.message, {icon: json.code === 0 ? 6 : 5});
                        if (json.code === 0) {
                            calendar.fullCalendar('removeEvents', function (ev) {
                                return (ev._id === calenderCalEvent._id);
                            });
                            calenderCalEvent = {};
                            modal.modal("hide");
                        }
                    });
                    // 取消删除
                }, function () {
                    layer.msg('您取消了删除操作！', {time: 800});
                });
            });
        });
    </script>
@endpush