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
        .always(function () {
            layer.close(mixLoading);
        }).fail(function () {
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
        .always(function () {
            layer.close(mixLoading);
        }).fail(function (response) {
            var html = '';
            if (response.responseJSON) {
                html += response.responseJSON.message + " <br/>";
                for (var i in response.responseJSON.errors) {
                    html += response.responseJSON.errors[i].join(";") + "<br/>";
                }
            } else {
                html = message;
            }

            layer.msg(html, {icon: 5});
        });
}

/**
 * 获取值
 *
 * @return mixed
 * @param arrValue
 * @param key
 * @param defaultValue
 */
function getValue(arrValue, key, defaultValue) {
    return arrValue[key] ? arrValue[key] : defaultValue;
}

// 初始化表单信息
function initForm(select, data) {
    var $fm = $(select),
        objForm = $fm.get(0); // 获取表单对象
    if (!objForm) return;

    // 第一步： 表单初始化
    $fm.find('input[type=hidden]').val('');
    $fm.find('input[type=checkbox]').each(function () {
        $(this).attr('checked', false);
        if ($(this).get(0)) $(this).get(0).checked = false;
    });                                                                             // 多选菜单
    objForm.reset();                                                                // 表单重置
    if (!data) return;

    // 第二步： 表单重新赋值
    for (var i in data) {
        // 多语言处理 以及多选配置
        if (typeof data[i] === 'object') {
            for (var x in data[i]) {
                var key = i + '[' + x + ']';
                // 对语言
                if (objForm[key] !== undefined) {
                    objForm[key].value = data[i][x];
                } else {
                    // 多选按钮
                    if (parseInt(data[i][x]) > 0) {
                        $('input[type=checkbox][name=' + i + '\\[\\]][value=' + data[i][x] + ']').attr('checked', true).each(function () {
                            this.checked = true
                        });
                    }
                }
            }
        }

        // 其他除密码的以外的数据
        if (objForm[i] !== undefined && objForm[i].type !== "password") {
            var obj = $(objForm[i]), tmp = data[i];
            objForm[i].value = tmp;
        }
    }

    return true;
}
