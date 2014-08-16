
<script type="text/javascript" src="/webix/webix.js"></script>

<link rel="stylesheet" type="text/css" href="/webix/webix.css">
<link rel="stylesheet" type="text/css" href="/webix/skins/web.css">

<div id="testA"></div>

<script type="text/javascript" charset="utf-8">

    webix.ready(function(){
        grida = new webix.ui({
            container:"testA",
            view:"datatable",
            columns:[
                { id:"id",  header:"#", width:80},
                { id:"title", header:"Заголовок",   width:400},
                { id:"created_at",  header:"Принято" ,    width:140},
                { id:"category_title", header:"Категория",        width:250},
                { id:"priority_title", header:"Приоритет",        width:150},
                { id:"status", header:"Статус",        width:100},
            ],
            autoheight:true,
            autowidth:true,
            
            url:"/admin/rest/tickets",
            on:{
                'itemclick': function(){
                    alert("item has just been clicked");
                }
            }
        });                             
    });
    </script>
