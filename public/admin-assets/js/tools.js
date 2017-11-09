var jqueryDataTableLanguage = {
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
};

// 设置ajax
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
    }
});

var mixLoading = null;

/**
 * ajax 自定义的ajax 处理
 * @param params
 * @param message
 * @returns {*}
 */
function ajax(params, message) {
    mixLoading = layer.load();
    return $.ajax(params)
        .always(function(){
        layer.close(mixLoading);
    }).fail(function() {
        layer.msg(message, {icon: 5});
    });
}

/**
 * 发送laravel 的请求
 * @param params
 * @param message
 * @returns {*}
 */
function getLaravelRequest(params, message) {
    mixLoading = layer.load();
    return $.ajax(params)
    .always(function(){
        layer.close(mixLoading);
    }).fail(function(response) {
        var html = '';
        if (response.responseJSON) {
            html += response.responseJSON.message+ " <br/>";
            for (var i in response.responseJSON.errors) {
                html += response.responseJSON.errors[i].join(";") + "<br/>";
            }
        } else {
            html = message;
        }

        layer.msg(html, {icon: 5});
    });
}