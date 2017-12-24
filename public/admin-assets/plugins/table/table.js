/**
 * Created by liujinxing on 2017/3/14.
 */

(function (window, $) {
    var other, html, i, mixLoading = null,
        meTables = function (options) {
            return new meTables.fn._construct(options);
        };

    // 时间格式化
    Date.prototype.Format = function (fmt) {
        var o = {
            "M+": this.getMonth() + 1,
            "d+": this.getDate(),
            "h+": this.getHours(),
            "m+": this.getMinutes(),
            "s+": this.getSeconds(),
            "q+": Math.floor((this.getMonth() + 3) / 3),
            "S": this.getMilliseconds()
        };

        if (/(y+)/.test(fmt)) {
            fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
        }

        for (var k in o) {
            if (new RegExp("(" + k + ")").test(fmt)) {
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length === 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
            }
        }

        return fmt;
    };

    meTables.fn = meTables.prototype = {
        constructor: meTables,

        // 初始化配置信息
        _construct: function (options) {
			this.options = this.extend(this.options, options);

            // 判断添加数据(多选)
            if (this.options.checkbox) {
                this.options.table.columns.unshift(this.options.checkbox);
            }

            // 添加操作选项

            // 表格的配置
            this.options.table = $.extend({
                "paging": true,
                "lengthMenu": [15, 30, 50, 100],
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "processing": true,
                "serverSide": true,
                "paginationType": "full_numbers",
                "language": this.getLanguage("dataTables", "*")
            }, this.options.table);

            // 没有配置地址
            if (!this.options.table.ajax) {
                var self = this;
                this.options.table.ajax = {
                    url: self.getUrl("search"),
                    data: function (d) {
                        d.where = $(self.options.searchForm).serialize();
                        return d;
                    }
                }
            }

            this.uniqueName = this.options.sTable.replace("#", "");

			return this.init();
        },

        // 初始化整个 meTables
        init: function (params) {
            this.action = "init";
            this.initRender();
            // 初始化主要表格
            this.table = $(this.options.sTable).DataTable(this.options.table);	
            var self = this;
            // 搜索表单的事件
            if (this.options.bEvent) {
                $(this.options.searchForm + ' input').on(this.options.searchInputEvent, function () {
                    self.table.draw();
                });
                $(this.options.searchForm + ' select').on(this.options.searchSelectEvent, function () {
                    self.table.draw();
                });
            }

            // 添加表单事件
            $(this.options.searchForm).submit(function (evt) {
                evt.preventDefault();
                self.search(true);
            });

            // 添加保存事件
            $(document).on('click', self.options.sTable + "-save", function (evt) {
                evt.preventDefault();
                self.save();
            });
            $(document).on('click', "." + self.uniqueName + "-update", function (evt) {
                evt.preventDefault();
                self.update($(this).attr("data-row"))
            })
            $(document).on('click', "." + self.uniqueName + "-delete", function (evt) {
                evt.preventDefault();
                self.delete($(this).attr("data-row"))
            });
            $(document).on('click', "." + self.uniqueName + "-detail", function (evt) {
                evt.preventDefault();
                self.detail($(this).attr("data-row"))
            });

            return this;
        },

        // 初始化页面渲染
        initRender: function () {
            if (!this.options.sFormId) {
                this.options.sFormId = "#" + this.uniqueName + "-form"; 
            }

            this.options.form.id = this.options.sFormId.replace("#", "");

            var self = this,
                form = "<form " + meTables.handleParams(this.options.form) + "><fieldset>",
                views = "<table class=\"table table-bordered table-striped table-detail\">",
                aOrders = [],
                aTargets = [];

            // 处理生成表单
            this.options.table.columns.forEach(function (k, v) {
                // 查看详情信息
                if (k.bViews !== false) {
                    views += meTables.detailTableCreate(k.title, k.data, v, self.options.detailTable, self.uniqueName);
                }

                // 编辑表单信息
                if (k.edit !== undefined) {
                    form += meTables.formCreate(k, self.options.editFormParams); 
                }

                // 搜索信息
                if (k.search !== undefined) {
                    self.options.searchHtml += meTables.searchInputCreate(k, v, self.options.searchType);  
                }

                // 默认排序
                if (k.defaultOrder) {
                    aOrders.push([v, k.defaultOrder]);  
                }

                // 是否隐藏                     
                if (k.hide) {
                    aTargets.push(v);
                }                                                   
            });

            var appendHtml = '';
            if (!self.options.sModal) {
                if (self.options.editFormParams.bMultiCols && meTables.empty(self.options.editFormParams.modalClass)) {
                    self.options.editFormParams.modalClass = "bs-example-modal-lg";
                    self.options.editFormParams.modalDialogClass = "modal-lg";
                }

                if (self.options.editFormParams.bMultiCols && self.options.editFormParams.index % self.options.editFormParams.iCols !== (self.options.editFormParams.iCols - 1)) {
                    form += "</div>";
                }

                self.options.sModal = "#" + self.uniqueName + "-modal";

                // 生成HTML
                appendHtml += meTables.modalCreate({
                    "params": {"id": self.options.sModal.replace("#", "")},
                    "html": form,
                    "button-id": self.uniqueName + "-save",
                    "modalClass": self.options.editFormParams.modalClass,
                    "modalDialogClass": self.options.editFormParams.modalDialogClass
                });
            }
            
            appendHtml += meTables.detailDivCreate(views, {"id": "data-detail-" + self.uniqueName});

            // 添加处理表格排序配置
            if (aOrders.length > 0) {
                this.options.table.order = aOrders;
            }

            // 添加处理表格隐藏字段
            if (aTargets.length > 0) {
                if (this.options.table.columnDefs) {
                    this.options.table.columnDefs.push({"targets": aTargets, "visible": false});
                } else {
                    this.options.table.columnDefs = [{"targets": aTargets, "visible": false}];
                }
            }

            // 向页面添加HTML
            $("body").append(appendHtml);
        },

        // 搜索
        search: function (params) {
            this.action = "search";
            if (!params) params = false;
            this.table.draw(params);
        },

        // 刷新
        refresh: function () {
            this.action = "refresh";
            this.search(true);
        },

        // 数据新增
        create: function () {
            this.action = "create";
            this.initForm(null);
        },

        // 数据修改
        update: function (row) {
            this.action = "update";
            this.initForm(this.table.data()[row]);
        },

        // 修改
        updateAll: function () {
            var selectLast = $(this.options.sTable + " tbody input:checkbox:checked:last");
            if (selectLast.length <= 0) {
                return layer.msg(this.getLanguage("noSelect"), {icon: 5});
            }

            this.update(selectLast.attr("data-row"));
        },

        // 数据删除
        delete: function (row) {
            var self = this;
            this.action = "delete";
            // 询问框
            layer.confirm(this.getLanguage("confirm").replace("_LENGTH_", ""), {
                title: self.getLanguage("confirmOperation"),
                btn: [self.getLanguage("determine"), self.getLanguage("cancel")],
                icon: 0
                // 确认删除
            }, function () {
                self.saveDelete(self.table.data()[row]);
                // 取消删除
            }, function () {
                layer.msg(self.getLanguage("cancelOperation"), {time: 800});
            });

        },

        // 删除全部数据
        deleteAll: function () {
            this.action = "deleteAll";
            var self = this, data = [];

            // 数据添加
            $(this.options.sTable + " tbody input:checkbox:checked").each(function () {
                var row = parseInt($(this).val()),
                    tmp = self.table.data()[row] ? self.table.data()[row] : null;
                if (tmp && tmp[self.options.pk]) data.push(tmp[self.options.pk]);
            });

            // 数据为空提醒
            if (data.length < 1) {
                return layer.msg(self.getLanguage("noSelect"), {icon: 5});
            }

            // 询问框
            layer.confirm(this.getLanguage("confirm").replace("_LENGTH_", data.length), {
                title: self.getLanguage("confirmOperation"),
                btn: [self.getLanguage("determine"), self.getLanguage("cancel")],
                shift: 4,
                icon: 0
                // 确认删除
            }, function () {
                self.saveDelete({"id": data.join(',')});
                $(self.options.sTable + " input:checkbox:checked").prop("checked", false);
                // 取消删除
            }, function () {
                layer.msg(self.getLanguage("cancelOperation"), {time: 800});
            });
        },

        // 查看详情
        detail: function (row) {
            if (this.options.oLoading) {
                return false;
            }

            var self = this,
                data = this.table.data()[row];
            if (data === undefined) {
                return false;
            }
            
            meTables.detailTable(this.options.table.columns, data, "." + self.uniqueName + "-data-detail-", row);
            // 弹出显示
            this.options.oLoading = layer.open({
                type: this.options.oViewConfig.type,
                shade: this.options.oViewConfig.shade,
                shadeClose: this.options.oViewConfig.shadeClose,
                title: self.options.title + self.getLanguage("sInfo"),
                content: $("#data-detail-" + self.uniqueName).removeClass("hide"), 			// 捕获的元素
                area: this.options.oViewConfig.area,
                cancel: function (index) {
                    layer.close(index);
                },
                end: function () {
                    $('.views-info').html('');
                    self.options.oLoading = null;
                    $("#data-detail-" + self.uniqueName).addClass("hide")
                },
                maxmin: this.options.oViewConfig.maxmin
            });

            // 展开全屏(解决内容过多问题)
            if (this.options.bViewFull) layer.full(this.options.oLoading);
        },

        // 删除和删除全部
        saveDelete: function (data) {
            var self = this;

            if (!data) {
                layer.msg(self.getLanguage("deleteDataEmpty"));
                return false;
            }

            // 验证处理类型
            if (!meTables.inArray(this.action, ["delete", "deleteAll"])) {
                layer.msg(self.getLanguage("operationError"));
                return false;
            }

            // 执行之前的数据处理
            if (typeof self.beforeDelete !== 'function' || self.beforeDelete(data)) {
                // ajax提交数据
                meTables.ajax({
                    url: self.getUrl(this.action),
                    type: "POST",
                    data: data,
                    dataType: "json"
                }).done(function (json) {
                    layer.msg(json.message, {icon: json.code === 0 ? 6 : 5});
                    // 判断操作成功
                    if (json.code === 0 && (
                        typeof self.afterDelete !== 'function' || self.afterDelete(json.data)
                    )) {
                        // 执行之后的数据处理
                        self.table.draw(false);
                        self.action = "saveDelete";
                    }
                });
            }

            return false;
        },


        // 修改之处理新增和修改
        save: function () {
            var self = this;

            // 验证处理类型
            if (!meTables.inArray(this.action, ["create", "update"])) {
                layer.msg(self.getLanguage("operationError"));
                return false;
            }

            // 验证表单填写数据
            if (!$(this.options.sFormId).validate(self.options.formValidate).form()) {
                return false;
            }

            var data = $(this.options.sFormId).serializeArray();
            // 执行之前的数据处理
            if (typeof self.beforeSave !== 'function' || self.beforeSave(data)) {
                // ajax提交数据
                meTables.ajax({
                    url: self.getUrl(this.action),
                    type: "POST",
                    data: data,
                    dataType: "json"
                }).done(function (json) {
                    layer.msg(json.message, {icon: json.code === 0 ? 6 : 5});
                    // 判断操作成功
                    if (json.code === 0 && (
                        typeof self.afterSave !== 'function' || self.afterSave(json.data)
                    )) {
                        // 执行之后的数据处理
                        self.table.draw(false);
                        $(self.options.sModal).modal("hide");
                        self.action = "save";
                    }
                });
            }

            return false;
        },

        // 获取连接地址
        getUrl: function (strType) {
            return this.options.url[strType];
        },

        // 初始化表单信息
        initForm: function (data) {
            layer.close(this.options.oLoading);
            // 显示之前的处理
            if (typeof this.beforeShow === "function" && !this.beforeShow(data)) {
                return false;
            }

            // 确定操作的表单和模型
            $(this.options.sModal).find("h4")
            .html(this.options.title + this.getLanguage(this.action === "create" ? "sCreate" : "sUpdate"));
            meTables.initForm(this.options.sFormId, data);

            // 显示之后的处理
            if (typeof this.afterShow === "function" && !this.afterShow(data)) {
                return false;
            }

            $(this.options.sModal).modal({backdrop: "static"});
        },

        // 获取语言配置信息
        getLanguage: function () {
            if (arguments.length > 1 && this.language[this.options.language][arguments[0]]) {
                return arguments[1] === "*" ?
                    this.language[this.options.language][arguments[0]] :
                    this.language[this.options.language][arguments[0]][arguments[1]];
            }

            return this.language[this.options.language].meTables[arguments[0]];
        }
    };

    meTables.fn._construct.prototype = meTables.fn;

    meTables.extend = meTables.fn.extend = function () {
        var name, options,
            target = arguments[0] || {},
            i = 1,
            length = arguments.length;
        if (length === i) {
            target = this;
            --i;
        }

        for (; i < length; i++) {
            if ((options = arguments[i]) !== null) {
                for (name in options) {
                    if (options[name] === target[name]) {
                        continue;
                    }

                    if (typeof target[name] === "object") {
                        target[name] = this.extend(target[name], options[name]);
                    } else if (options[name] !== undefined) {
                        target[name] = options[name];
                    }
                }
            }
        }

        return target;
    };

    meTables.extend({
        // 扩展AJAX
        ajax: function (params) {
            mixLoading = layer.load();
            return $.ajax(params).always(function () {
                layer.close(mixLoading);
            }).fail(function () {
                layer.msg(meTables.fn.getLanguage("sServerError"), {icon: 5});
            });
        },

        // 判断是否存在数组中
        inArray: function (value, array) {
            if (typeof array === "object") {
                for (var i in array) {
                    if (array[i] === value) {
                        return true;
                    }
                }
            }

            return false;
        },

        // 是否为空
        empty: function (value) {
            return value === undefined || value === "" || value === null;
        },

        isObject: function (value) {
            return typeof value === "object";
        },

        // 处理参数
        handleParams: function (params, prefix) {
            other = "";
            if (params !== undefined && typeof params === "object") {
                prefix = prefix ? prefix : '';
                for (var i in params) {
                    other += " " + i + '="' + prefix + params[i] + '"'
                }

                other += " ";
            }

            return other;
        },

        labelCreate: function (content, params) {
            return "<label" + this.handleParams(params) + "> " + content + " </label>";
        },

        inputCreate: function (params) {
            if (!params.type) params.type = "text";
            return "<input" + this.handleParams(params) + "/>";
        },

        textCreate: function (params) {
            params.type = "text";
            return this.inputCreate(params);
        },

        passwordCreate: function (params) {
            params.type = "password";
            return this.inputCreate(params);
        },

        fileCreate: function (params) {
            var o = params.options;
            delete params.options;
            html = '<input type="hidden" ' + this.handleParams(params) + '/>';
            o.type = "file";
            return html + this.inputCreate(o);
        },

        radioCreate: function (params, d) {
            html = "";
            if (d && this.isObject(d)) {
                params['class'] = "ace valid";
                var c = params.default;
                params = this.handleParams(params);
                for (i in d) {
                    html += '<label class="line-height-1 blue"> ' +
                        '<input type="radio" ' + params + (c == i ? ' checked="checked" ' : "") + ' value="' + i + '"  /> ' +
                        '<span class="lbl"> ' + d[i] + " </span> " +
                        "</label>　 "
                }
            }

            return html;
        },

        checkboxCreate: function (params, d) {
            html = '';
            if (d && this.isObject(d)) {
                var o = params.all, c = params.divClass ? params.divClass : "col-xs-6";
                delete params.all;
                delete params.divClass;
                params["class"] = "ace m-checkbox";
                params = handleParams(params);
                if (o) {
                    html += '<div class="checkbox col-xs-12">' +
                        '<label>' +
                        '<input type="checkbox" class="ace checkbox-all" onclick="var isChecked = $(this).prop(\'checked\');$(this).parent().parent().parent().find(\'input[type=checkbox]\').prop(\'checked\', isChecked);" />' +
                        '<span class="lbl"> ' + meTables.fn.getLanguage("sSelectAll") + ' </span>' +
                        '</label>' +
                        '</div>';
                }
                for (i in d) {
                    html += '<div class="checkbox ' + c + '">' +
                        '<label>' +
                        '<input type="checkbox" ' + params + ' value="' + i + '" />' +
                        '<span class="lbl"> ' + d[i] + ' </span>' +
                        '</label>' +
                        '</div>';
                }
            }

            return html;
        },

        selectCreate: function (params, d) {
            html = "";
            if (d && this.isObject(d)) {
                var c = params.default;
                delete params.default;
                if (params.multiple) {
                    params.name += "[]";
                }
                html += "<select " + this.handleParams(params) + ">";
                for (i in d) {
                    html += '<option value="' + i + '" ' + (i == c ? ' selected="selected" ' : "") + " >" + d[i] + "</option>";
                }

                html += "</select>";
            }

            return html
        },

        textareaCreate: function (params) {
            if (!params["class"]) params["class"] = "form-control";
            if (!params["rows"]) params["rows"] = 5;
            html = (params.value ? params.value : "") + "</textarea>";
            delete params.value;
            return "<textarea" + this.handleParams(params) + ">" + html;
        },

        // 搜索框表单元素创建
        searchInputCreate: function (k, v, searchType) {
            // 默认值
            if (!k.search.name) k.search.name = k.data;
            if (!k.search.title) k.search.title = k.title;
            if (!k.search.type) k.search.type = "text";

            // select 默认选中
            var defaultObject = k.search.type === "select" ? {"All": meTables.fn.getLanguage("all")} : null;

            if (searchType === "middle") {
                try {
                    html = this[k.search.type + "SearchMiddleCreate"](k.search, k.value, defaultObject);
                } catch (e) {
                    html = this.textSearchMiddleCreate(k.search);
                }
            } else {
                try {
                    html = this[k.search.type + "SearchCreate"](k.search, k.value, defaultObject);
                } catch (e) {
                    html = this.textSearchCreate(k.search);
                }
            }

            return html;
        },

        buttonsCreate: function (index, data) {
            var div1 = '<div class="hidden-sm hidden-xs btn-group">',
                div2 = '<div class="hidden-md hidden-lg"><div class="inline position-relative"><button data-position="auto" data-toggle="dropdown" class="btn btn-minier btn-primary dropdown-toggle"><i class="ace-icon fa fa-cog icon-only bigger-110"></i></button><ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">';
            // 添加按钮信息
            if (data !== undefined && typeof data === "object") {
                for (var i in data) {
                    div1 += ' <button class="btn ' + data[i]['className'] + ' ' + data[i]['cClass'] + ' btn-xs" table-data="' + index + '"><i class="ace-icon fa ' + data[i]["icon"] + ' bigger-120"></i> ' + (data[i]["button-title"] ? data[i]["button-title"] : '') + '</button> ';
                    div2 += '<li><a title="' + data[i]['title'] + '" data-rel="tooltip" class="tooltip-info ' + data[i]['cClass'] + '" href="javascript:;" data-original-title="' + data[i]['title'] + '" table-data="' + index + '"><span class="' + data[i]['sClass'] + '"><i class="ace-icon fa ' + data[i]['icon'] + ' bigger-120"></i></span></a></li>';
                }
            }

            return div1 + '</div>' + div2 + '</ul></div></div>';
        },

        formCreate: function (k, oParams) {
            var form = '';
            if (!oParams.index) oParams.index = 0;

            // 处理其他参数
            if (!k.edit.type) k.edit.type = "text";
            if (!k.edit.name) k.edit.name = k.data;

            if (k.edit.type === "hidden") {
                form += this.inputCreate(k.edit);
            } else {
                k.edit["class"] = "form-control " + (k.edit["class"] ? k.edit["class"] : "");
                // 处理多列
                if (oParams.iMultiCols > 1 && !oParams.aCols) {
                    oParams.aCols = [];
                    var iLength = Math.ceil(12 / oParams.iMultiCols);
                    oParams.aCols[0] = Math.floor(iLength * 0.3);
                    oParams.aCols[1] = iLength - oParams.aCols[0];
                }

                if (!oParams.bMultiCols || (oParams.iColsLength > 1 && oParams.index % oParams.iColsLength === 0)) {
                    form += '<div class="form-group">';
                }

                form += this.labelCreate(k.title, {"class": "col-sm-" + oParams.aCols[0] + " control-label"});
                form += '<div class="col-sm-' + oParams.aCols[1] + '">';

                // 使用函数
                try {
                    form += this[k.edit.type + "Create"](k.edit, k.value);
                } catch (e) {
                    k.edit.type = "text";
                    form += this["inputCreate"](k.edit);
                }

                form += '</div>';

                if (!oParams.bMultiCols || (oParams.iColsLength > 1 && oParams.index % oParams.iColsLength === (oParams.iColsLength - 1))) {
                    form += '</div>';
                }

                oParams.index ++;
            }

            return form;
        },

        selectInput: function (params, value, defaultObject) {
            html = "";
            if (defaultObject) {
                for (i in defaultObject) {
                    html += '<option value="' + i + '" selected="selected">' + defaultObject[i] + '</option>';
                }
            }

            if (value) {
                for (i in value) {
                    html += '<option value="' + i + '">' + value[i] + '</option>';
                }
            }

            if (params.multiple) params.name += "[]";
            return '<select ' + this.handleParams(params) + '>' + html + '</select>';
        },

        textSearchMiddleCreate: function (params) {
            params["id"] = "search-" + params.name;
            return '<label for="search-' + params.name + '"> ' + params.title + ': ' + this.inputCreate(params) + '</label>';
        },

        selectSearchMiddleCreate: function (params, value, defaultObject) {
            params["id"] = "search-" + params.name;
            return '<label for="search-' + params.name + '"> ' + params.title + ': ' + this.selectInput(params, value, defaultObject) + '</label>';
        },

        searchParams: function (params) {
            var defaultParams = {
                "id": "search-" + params.name,
                "name": params.name,
                "class": "form-control"
            }, defaultLabel = {
                "for": "search-" + params.name
            }, options = params.options, labelOptions = params.labelOptions;

            // 删除多余信息
            delete params.options;
            delete params.labelOptions;

            defaultParams = this.extend(defaultParams, params);
            if (options) {
                defaultParams = this.extend(defaultParams, options);
            }

            if (labelOptions) {
                defaultLabel = this.extend(defaultLabel, labelOptions);
            }

            return {
                input: defaultParams,
                label: defaultLabel
            }
        },

        textSearchCreate: function (params) {
            // 默认赋值
            if (!params.placeholder) {
                params.placeholder = meTables.fn.getLanguage("pleaseInput") + params.title;
            }

            if (!params.labelOptions) {
                params.labelOptions = {"class": "sr-only"};
            }

            var options = this.searchParams(params);

            return '<div class="form-group">\
                <label' + this.handleParams(options.label) + '>' + params.title + '</label>\
                <input type="text"' + this.handleParams(options.input) + '>\
                </div> ';
        },

        selectSearchCreate: function (params, value, defaultObject) {
            var options = this.searchParams(params), i = null;
            return '<div class="form-group">\
                <label' + this.handleParams(options.label) + '>' + params.title + '</label>\
                ' + this.selectInput(options.input, value, defaultObject) + '\
                </div> ';
        },

        // 初始化表单信息
        initForm: function (select, data) {
            var $fm = $(select);
            objForm = $fm.get(0); // 获取表单对象
            if (objForm !== undefined) {
                $fm.find("input[type=hidden]").val("");
                $fm.find("input[type=checkbox]").each(function () {
                    $(this).attr('checked', false);
                    if ($(this).get(0)) $(this).get(0).checked = false;
                });                                                                             // 多选菜单
                objForm.reset();                                                                // 表单重置
                if (data !== undefined) {
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
                            // 时间处理
                            if (obj.hasClass('time-format')) {
                                tmp = mt.timeFormat(parseInt(tmp), obj.attr('time-format') ? obj.attr('time-format') : "yyyy-MM-dd hh:mm:ss");
                            }
                            objForm[i].value = tmp;
                        }
                    }
                }
            }
        },

        divCreate: function (params) {
            return '<div' + this.handleParams(params) + '></div>'
        },

        dateCreate: function (params) {
            return '<div class="input-group bootstrap-datepicker"> \
                <input class="form-control date-picker ' + (params["class"] ? params["class"] : "") + '"  type="text" ' + this.handleParams(params) + '/> \
                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span> \
                </div>';
        },

        timeCreate: function (params) {
            return '<div class="input-group bootstrap-timepicker"> \
                <input type="text" class="form-control time-picker ' + (params["class"] ? params["class"] : "") + '" ' + this.handleParams(params) + '/> \
                <span class="input-group-addon"><i class="fa fa-clock-o bigger-110"></i></span> \
                </div>';
        },

        // 添加时间
        dateTimeCreate: function (params) {
            return '<div class="input-group bootstrap-datetimepicker"> \
                <input type="text" class="form-control datetime-picker ' + (params["class"] ? params["class"] : "") + '" ' + this.handleParams(params) + '/> \
                <span class="input-group-addon"><i class="fa fa-clock-o bigger-110"></i></span> \
                </div>';
        },

        // 时间段
        timeRangeCreate: function (params) {
            return '<div class="input-daterange input-group"> \
                <input type="text" class="input-sm form-control" name="start" /> \
                <span class="input-group-addon"><i class="fa fa-exchange"></i></span> \
                <input type="text" class="input-sm form-control" name="end" /> \
            </div>';
        },

        // 添加时间段
        dateRangeCreate: function (params) {
            return '<div class="input-group"> \
                <span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span> \
                <input class="form-control daterange-picker ' + (params["class"] ? params["class"] : "") + '" type="text" ' + this.handleParams(params) + ' /> \
            </div>';
        },

        detailTable: function (object, data, tClass, row) {
            // 循环处理显示信息
            object.forEach(function (k) {
                var tmpKey = k.data, tmpValue = data[tmpKey], dataInfo = $(tClass + tmpKey);
                if (k.edit !== undefined && k.edit.type === 'password') tmpValue = "******";
                (k.createdCell !== undefined && typeof k.createdCell === "function") ? k.createdCell(dataInfo, tmpValue, data, row, undefined) : dataInfo.html(tmpValue);
            });
        },

        detailTableCreate: function (title, data, iKey, aParams, prefix) {
            html = '';
            if (aParams && aParams.bMultiCols) {
                if (aParams.iColsLength > 1 && iKey % aParams.iColsLength === 0) {
                    html += '<tr>';
                }

                html += '<td width="25%">' + title + '</td><td class="views-info data-detail-' + data + '"></td>';

                if (aParams.iColsLength > 1 && iKey % aParams.iColsLength === (aParams.iColsLength - 1)) {
                    html += '</tr>';
                }
            } else {
                html += '<tr><td width="25%">' + title + '</td><td class="views-info ' + prefix + '-data-detail-' + data + '"></td></tr>';
            }

            return html;
        },

        detailDivCreate: function(content, params) {
            params.class =  params.class ? params + " hide" : "hide";
            return '<div ' + this.handleParams(params) + '> ' + content + ' </table></div>';
        },

        modalCreate: function (oModal) {
            return '<div class="modal fade ' + (oModal["modalClass"] ? oModal["modalClass"] : "") + '" ' + this.handleParams(oModal['params']) + ' tabindex="-1" role="dialog" > \
                <div class="modal-dialog ' + (oModal["modalDialogClass"] ? oModal["modalDialogClass"] : "") + '" role="document"> \
                    <div class="modal-content"> \
                        <div class="modal-header"> \
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> \
                            <h4 class="modal-title"></h4> \
                        </div> \
                        <div class="modal-body">' + oModal['html'] + '</fieldset></form></div> \
                        <div class="modal-footer"> \
                            <button type="button" class="btn btn-default" data-dismiss="modal">' + meTables.fn.getLanguage("sBtnCancel") + '</button> \
                            <button type="button" class="btn btn-primary btn-image ' + (oModal['bClass'] ? oModal['bClass'] : '') + '" ' + (oModal["button-id"] ? 'id="' + oModal["button-id"] + '"' : "") + '>' + meTables.fn.getLanguage("sBtnSubmit") + '</button> \
                        </div> \
                    </div> \
                </div> \
            </div>';
        },

        // 根据时间戳返回时间字符串
        timeFormat: function (time, str) {
            if (!str) str = "yyyy-MM-dd";
            var date = new Date(time * 1000);
            return date.Format(str);
        },

        // 时间戳转字符日期
        dateTimeString: function (td, data) {
            $(td).html(mt.timeFormat(data, 'yyyy-MM-dd hh:mm:ss'));
        },

        // 状态信息
        statusString: function (td, data) {
            $(td).html('<span class="label label-' + (parseInt(data) === 1 ? 'success">启用' : 'warning">禁用') + '</span>');
        },

        // 用户显示
        adminString: function (td, data) {
            $(td).html(aAdmins[data]);
        },

        // 显示标签
        valuesString: function (data, color, value, defaultClass) {
            if (!defaultClass) defaultClass = 'label label-sm ';
            return '<span class="' + defaultClass + ' ' + (color[value] ? color[value] : '') + '"> ' + (data[value] ? data[value] : value) + ' </span>';
        }

    });

    // 设置默认配置信息
    meTables.fn.extend({
        options: {
            sModal: "",                 // 编辑Modal选择器
            title: "",                  // 表格的标题
            language: "zh-cn",          // 使用语言
            sTable: "#show-table", 	    // 显示表格选择器
            sFormId: "",		        // 编辑表单选择器
            // 需要多选框
            checkbox: {
                "data": null,
                "bSortable": false,
                "class": "center",
                "title": '<input type="checkbox" class="all" />',
                "bViews": false,
                "createdCell": function (td, data, array, row, col) {
                    $(td).html('<input type="checkbox" class="input-checkbox" value="' + row + '" data-row="' + row + '" />');
                }
            },			    
            params: null,				// 请求携带参数
            searchForm: "#search-form",	// 搜索表单选择器
            bEvent: true,               // 是否监听事件
            searchInputEvent: "blur",   // 搜索表单input事件
            searchSelectEvent: "change",// 搜索表单select事件

            // 编辑表单信息
            form: {
                "method": "post",
                "class": "form-horizontal",
                "name": "edit-form"
            },

            // 编辑表单验证方式
            formValidate: {
                errorElement: 'div',
                errorClass: 'help-block',
                focusInvalid: false,
                highlight: function (e) {
                    $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
                },
                success: function (e) {
                    $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                    $(e).remove();
                }
            },

            // 表单编辑其他信息
            editFormParams: {				// 编辑表单配置
                bMultiCols: false,          // 是否多列
                iColsLength: 1,             // 几列
                aCols: [3, 9],              // label 和 input 栅格化设置
                sModalClass: "",			// 弹出模块框配置
                sModalDialogClass: ""		// 弹出模块的class
            },

            // 关于详情的配置
            bViewFull: false, // 详情打开的方式 1 2 打开全屏
            oViewConfig: {
                type: 1,
                shade: 0.3,
                shadeClose: true,
                maxmin: true,
                area: ['50%', 'auto']
            },

            detailTable: {                   // 查看详情配置信息
                bMultiCols: false,
                iColsLength: 1
            },

            // 关于地址配置信息
            url: {
                create: "create",
                update: "update",
                delete: "delete",
                export: "export",
                upload: "upload",
                deleteAll: "delete-all"
            }
        },

        // 语言配置
        language: {
            "zh-cn": {
                // 我的信息
                meTables: {
                    "operations": "操作",
                    "operations_see": "查看",
                    "operations_update": "编辑",
                    "operations_delete": "删除",
                    "sBtnCancel": "取消",
                    "sBtnSubmit": "确定",
                    "sSelectAll": "选择全部",
                    "sInfo": "详情",
                    "sCreate": "新增",
                    "sUpdate": "编辑",
                    "sExport": "数据正在导出, 请稍候...",
                    "sAppearError": "出现错误",
                    "sServerError": "服务器繁忙,请稍候再试...",
                    "determine": "确定",
                    "cancel": "取消",
                    "confirm": "您确定需要删除这_LENGTH_条数据吗?",
                    "confirmOperation": "确认操作",
                    "cancelOperation": "您取消了删除操作!",
                    "noSelect": "没有选择需要操作的数据",
                    "operationError": "操作有误",
                    "deleteDataEmpty": "删除数据为空",
                    "search": "搜索",
                    "create": "添加",
                    "updateAll": "修改",
                    "deleteAll": "删除",
                    "refresh": "刷新",
                    "export": "导出",
                    "pleaseInput": "请输入",
                    "all": "全部"
                },

                // dataTables 表格
                dataTables: {
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
                }
            }
        }
    });

    window.meTables = window.mt = meTables;
    return meTables;
})(window, jQuery);