@extends("admin.layouts.admin")

@section('header_title', '日程管理')
@section('header_description', '我的日程')
@php
$breadCrumb = [
    ['label' => '123', 'url' => '/admin/uploads/index'],
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
                        <div class="external-event bg-green">Lunch</div>
                        <div class="external-event bg-yellow">Go home</div>
                        <div class="external-event bg-aqua">Do homework</div>
                        <div class="external-event bg-light-blue">Work on UI design</div>
                        <div class="external-event bg-red">Sleep tight</div>
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
                        <input id="new-event" type="text" class="form-control" placeholder="{{ trans('admin.eventTitle') }}">
                        <div class="input-group-btn">
                            <button id="add-new-event" type="button" class="btn btn-primary btn-flat"> {{ trans('admin.create') }} </button>
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
    <div class="modal fade" id="calendarModal"  tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"> 编辑日程事件信息 </h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="editForm" class="form-horizontal" name="editForm" action="update">
                        <input type="hidden" name="actionType" value="insert" />
                        <input type="hidden" name="id"         value="" />
                        <input type="hidden" name="admin_id"   value="" />
                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="input-title"> 事件标题 </label>
                                <div class="col-sm-9">
                                    <input type="text" id="input-title" required="true" rangelength="[2, 100]" name="title" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="desc"> 事件描述 </label>
                                <div class="col-sm-9">
                                    <textarea required="true" rangelength="[2, 255]" id="desc" name="desc" class="form-control form-control" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="start_at"> 开始时间 </label>
                                <div class="col-sm-9">
                                    <div class="input-group bootstrap-datetimepicker">
                                        <input type="text" class="form-control datetime-picker me-datetime" id="start_at" required="true" name="start_at">
                                        <span class="input-group-addon"><i class="fa fa-clock-o bigger-110"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="end_at"> 结束时间 </label>
                                <div class="col-sm-9">
                                    <div class="input-group bootstrap-datetimepicker">
                                        <input type="text" class="form-control datetime-picker me-datetime" id="end_at" required="true" name="end_at">
                                        <span class="input-group-addon">
                                        <i class="fa fa-clock-o bigger-110"></i>
                                    </span>
                                    </div>
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
@endpush
@push("script")
    <script src="{{ asset('admin-assets/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/datepicker/moment.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <!-- Page specific script -->
    <script>
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
        function formUpdateObject(form, calEvent, isSubmit)
        {
            calenderCalEvent = calEvent;
            formObject(form, {
                id:          calEvent.id,                                   // ID
                title:       $.trim(calEvent.title),                        // 标题
                desc:        $.trim(calEvent.desc),                         // 说明描述
                start_at:    calEvent.start.format('YYYY-MM-DD HH:mm:ss'),  // 时间开始
                end_at:      calEvent.end.format('YYYY-MM-DD HH:mm:ss'),    // 时间结束
                time_status: calEvent.time_status,                          // 时间状态
                status:      calEvent.status,                               // 状态
                actionType:  'update'
            });

            if (isSubmit == true) $('#update-calendar').trigger('click');
        }

        $(function () {
            $('#external-events div.external-event').each(function(){
                $(this).draggable({
                    zIndex: 1070,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                })
            });

            /* initialize the calendar
             -----------------------------------------------------------------*/
            $('#calendar').fullCalendar({
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

                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject')

                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject)

                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;
                    copiedEventObject.backgroundColor = $(this).css('background-color')
                    copiedEventObject.borderColor = $(this).css('border-color')

                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove()
                    }

                },

                /**
                 * 事件被拖拽
                 * calEvent      已经移动后的事件对象
                 * dayDelta      保存日程向前或者向后移动了多少的数据
                 * minuteDelta   这个值只有在agenda视图有效，移动的时间
                 * allDay        如果是月视图,或者是agenda视图的全天日程，此值为true,否则为false
                 */
                eventDrop: function(calEvent, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {
                    // 表单重新赋值
                    console.info(arguments, 1);
                },
                /**
                 * 事件改变大小
                 * calEvent      已经移动后的事件对象
                 * dayDelta      保存日程向前或者向后移动了多少的数据
                 * minuteDelta   这个值只有在agenda视图有效，移动的时间
                 * allDay        如果是月视图,或者是agenda视图的全天日程，此值为true,否则为false
                 */
                eventResize: function(calEvent, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {
                    // 表单重新赋值
                    console.info(arguments, 2);
                },

                selectable: true,
                selectHelper: true,
                // 点击日期事件
                select: function(start, end, allDay) {
                    $('#delete-calendar').hide();
//                    // 默认赋值
//                    formObject(form, {
//                        'start_at':     start.format('YYYY-MM-DD HH:mm:ss'),     // 时间开始
//                        'end_at':       end.format('YYYY-MM-DD HH:mm:ss'),       // 时间结束
//                        'time_status':  1,                                       // 时间状态
//                        'status'     :  1,                                       // 状态
//                        'actionType':  'create'                                  // 操作类型
//                    });
                    // 添加一个新的日程事件
                    modal.modal('show').find('h4').html('添加一个新的事件');
                },

                // 事件被点击
                eventClick: function(calEvent, jsEvent, view) {
                    $('#delete-calendar').show();
                    // 开始赋值显示编辑
//                    formUpdateObject(form, calEvent);
                    modal.modal('show').find('h4').html('编辑日程事件信息');
                }
            });

            /* ADDING EVENTS */
            var currColor = '#3c8dbc' //Red by default
            //Color chooser button
            var colorChooser = $('#color-chooser-btn')
            $('#color-chooser > li > a').click(function (e) {
                e.preventDefault()
                //Save color
                currColor = $(this).css('color');
                console.info(currColor);
                //Add color effect to button
                $('#add-new-event').css({'background-color': currColor, 'border-color': currColor})
            });

            $('#add-new-event').click(function (e) {
                e.preventDefault()
                //Get value and make sure it is not null
                var val = $('#new-event').val()
                if (val.length == 0) {
                    return
                }

                //Create events
                var event = $('<div />')
                event.css({
                    'background-color': currColor,
                    'border-color': currColor,
                    'color': '#fff'
                }).addClass('external-event')
                event.html(val)
                $('#external-events').prepend(event)

                //Add draggable funtionality
                init_events(event)

                //Remove event from text input
                $('#new-event').val('')
            })
        })
    </script>
@endpush