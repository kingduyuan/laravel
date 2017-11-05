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