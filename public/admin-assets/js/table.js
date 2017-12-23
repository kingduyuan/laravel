;(function ($) {
    $.fn.table = function (params, config) {

        return this.DataTable($.extend({
            "dom": "t<'row'<'col-xs-6'li><'col-xs-6'p>>",
            "paging": true,
            "lengthMenu": [15, 30, 50, 100],
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "language": {
                "decimal": "",
                "emptyTable": "没有数据呢 ^.^",
                "info": "显示 _START_ 到 _END_ 共有 _TOTAL_ 条数据",
                "infoEmpty": "无记录",
                "infoFiltered": "(从 _MAX_ 条记录过滤)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "每页 _MENU_ 条记录",
                "loadingRecords": "加载中...",
                "processing": "处理中...",
                "search": "搜索:",
                "zeroRecords": "没有找到记录",
                "paginate": {
                    "first": "首页",
                    "last": "尾页",
                    "next": "下一页",
                    "previous": "上一页"
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            },
        }, params))
    }
})(window.jQuery);