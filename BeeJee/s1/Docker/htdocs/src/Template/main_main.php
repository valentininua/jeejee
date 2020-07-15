<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>window.jQuery || document.write(decodeURIComponent('%3Cscript src="js/jquery.min.js"%3E%3C/script%3E'))</script>
<link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/20.1.3/css/dx.common.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/20.1.3/css/dx.light.css"/>
<script src="https://cdn3.devexpress.com/jslib/20.1.3/js/dx.all.js"></script>
<script src="https://unpkg.com/devextreme-aspnet-data@2.2.1/js/dx.aspnet.data.js"></script>

<style>
    .status-icon {
        height: 16px;
        width: 16px;
        display: inline-block;
        margin-right: 8px;
    }
    .middle {
        vertical-align: middle;
    }
</style>

<script>
    var MainClass = {
        config : {
            auth: <?php  echo (!isset($_SESSION['auth'])) ? 'false' : 'true'; ?>,
        },
        customers : <?php echo $arr['allTaskData'];?>,
        statuses : [
            {
                "id": 1, "name": "Не начато"
            },
            // #for examle
            //{
            //     "id": 2, "name": "В ходе выполнения"
            // }, {
            //     "id": 3, "name": "Отложенный"
            // }, {
            //     "id": 4, "name": "Нужна помощь"
            // },
            {
                "id": 5, "name": "Завершенный"
            }
        ],
        session: function(){
            //MainClass.config.auth = true
            $.post( "/Auth/check/", { func: "getNameAndTime" }, function( data ) {
                MainClass.config.auth = data.checkSession;
                if (!MainClass.config.auth) {
                    DevExpress.ui.notify("Вы не авторизированы", "info", 1500);
                }

            }, "json");
        },
        rowUpdated: function(params) {
            console.log(params);
            return $.ajax({
                url: "/ajax/rowUpdated",
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({
                    id: params.data.id,
                    Email: params.data.Email,
                    Name: params.data.Name,
                    Status: params.data.Status,
                    Task: params.data.Task,
                })
            });
        },
        rowInserted: function(params) {
            console.log(params);
            return $.ajax({
                url: "/ajax/rowInserted",
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({
                    id: params.data.ID,
                    Email: params.data.Email,
                    Name: params.data.Name,
                    Status: params.data.Status,
                    Task: params.data.Task,
                }),

            });
        },
        rowRemoved: function(params) {
            console.log(params);
            return $.ajax({
                url: "/ajax/rowRemoved",
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({
                    id: params.data.ID,
                    Email: params.data.Email,
                    Name: params.data.Name,
                    Status: params.data.Status,
                    Task: params.data.Task,
                })
            });

        },
    }

    $(function () {
        /**
         *
         * @param eventName
         */
        function logEvent(eventName) {
            console.log(eventName);
        }

        $("#popupContainer").dxPopup({
            title: "Popup Auth"
        });


        $("#gridContainer").dxDataGrid({
            dataSource: MainClass.customers,
            searchPanel: {
                visible: true
            },
            paging: {
                pageSize: 3
            },
            editing: {
                mode: "row",
                allowUpdating: MainClass.config.auth, // if  admin => true
                allowDeleting: MainClass.config.auth, // if  admin => true
                allowAdding: MainClass.config.auth,   // true
            },
            pager: {
                showPageSizeSelector: true,
                allowedPageSizes: [2, 4, 20],
                showInfo: true
            },
            columns: [
                {
                    dataField: "id",
                    caption: "N",
                    allowEditing: false,
                    width: 55,
                },
                {
                    dataField: "Name",
                    caption: "Имя пользователя",
                    validationRules: [{type: "required"}]
                },
                {
                    dataField: "Email",
                    caption: "Email",
                    validationRules: [{
                        type: "required"
                    }, {
                        type: "email"
                    }, {
                        type: "async",
                        message: "Email address is not unique",
                        validationCallback: function (params) {
                            MainClass.session();
                            return $.ajax({
                                url: "/ajax/CheckUniqueEmailAddress",
                                type: 'POST',
                                dataType: 'json',
                                contentType: 'application/json',
                                data: JSON.stringify({
                                    id: params.data.ID,
                                    email: params.value,
                                })
                            });
                        }
                    }],
                },
                {
                    dataField: "Task",
                    caption: "Текст задачи",
                    validationRules: [{type: "required"}],
                },
                {
                    caption: "Статус",
                    columns: [
                        {
                            dataField: "Status",
                            caption: "",
                            allowEditing:  MainClass.config.auth, //false, // if admin == true
                            width: 125,
                            <?php if (isset($_SESSION['auth'])) { ?> validationRules: [{type: "required"}], <?php } ?>
                            lookup: {
                                dataSource: MainClass.statuses,
                                displayExpr: "name",
                                valueExpr: "id",
                            }
                        },
                        {
                            dataField: "Edited",
                            caption: '',
                            allowEditing: false, //config.auth, //false, // if admin == true
                            calculateDisplayValue: function (rowData) { // combines display values
                                MainClass.session();
                                if (1 == rowData.Edited) {
                                    return "отредактировано администратором";
                                } else {
                                    return ' ';
                                }
                            },
                            width: 105,
                            template: function (data, itemElement) {
                            }
                        },
                    ]
                }
            ],
            onEditingStart: function (e) {
                MainClass.session();
                logEvent("EditingStart");
            },
            onInitNewRow: function (e) {
                MainClass.session();
                logEvent("InitNewRow");
            },
            onRowInserting: function (e) {
                MainClass.session();
                e.cancel = !MainClass.config.auth;
                logEvent("RowInserting");
                if (e.cancel) {
                    $("#popupContainer").dxPopup( { visible: true , fullScreen:true, showCloseButton:false});
                    DevExpress.ui.notify("НЕ Добавлено", "warning", 500);
                } else {
                    DevExpress.ui.notify("Добавлено в конец списка", "warning", 500);
                }
            },
            onRowInserted: function (e) {
                MainClass.session();
                MainClass.rowInserted(e)
                logEvent("RowInserted");
            },
            onRowUpdating: function (e) {
                MainClass.session();
                logEvent("RowUpdating");
                e.cancel = !MainClass.config.auth;
                if (e.cancel) {
                    $("#popupContainer").dxPopup( { visible: true , fullScreen:true, showCloseButton:false});
                    DevExpress.ui.notify("НЕ Добавлено", "warning", 500);
                } else {
                    DevExpress.ui.notify("Выполнено", "warning", 500);
                }
            },
            onRowUpdated: function (e) {
                MainClass.session();
                MainClass.rowUpdated(e)
                logEvent("RowUpdated");
                e.cancel = !MainClass.config.auth;
                if (e.cancel) {
                    $("#popupContainer").dxPopup( { visible: true , fullScreen:true, showCloseButton:false});
                    DevExpress.ui.notify("НЕ Выполнено", "warning", 500);
                } else {
                    DevExpress.ui.notify("Выполнено", "warning", 500);
                }
            },
            onRowRemoving: function (e) {
                MainClass.session();
                logEvent("RowRemoving");
                e.cancel = !MainClass.config.auth;
                if (e.cancel) {
                    $("#popupContainer").dxPopup( { visible: true , fullScreen:true, showCloseButton:false});
                    DevExpress.ui.notify("НЕ Выполнено", "warning", 500);
                } else {
                    DevExpress.ui.notify("Выполнено", "warning", 500);
                }
            },
            onRowRemoved: function (e) {
                MainClass.session();

                e.cancel = !MainClass.config.auth;
                if (e.cancel) {
                   // $("#popupContainer").dxPopup("show");
                    $("#popupContainer").dxPopup( { visible: true , fullScreen:true, showCloseButton:false});
                    DevExpress.ui.notify("НЕ Выполнено", "warning", 500);
                } else {
                    DevExpress.ui.notify("Выполнено", "warning", 500);
                }
                MainClass.rowRemoved(e)
                logEvent("RowRemoved");
            }
        });
    });
</script>
<div class="dx-viewport">
    <div class="demo-container">
        <div id="gridContainer"></div>
    </div>
</div>

<div id="popupContainer">
    <center><p> Перейдите на форму авторизации  <a href="/Auth/login/">  тут </a> </p></center>
</div>
