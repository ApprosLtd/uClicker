<script type="text/javascript" src="/packages/handlebars/handlebars-v1.3.0.js"></script>

<link rel="stylesheet" href="/packages/gridman/gridman.css">
<script type="text/javascript" src="/packages/gridman/jquery.gridman.js"></script>

<div class="row">
    <div class="col-md-9"><h3 style="margin: 3px 0 0;">{{ $title or '' }}</h3></div>
</div>

<script>
    function saveEditForm(grid){
        //
    }
    function onPressAddingBtn(grid){
        //
    }
    function onPressEditBtn(grid, index){
        //
    }
    var gridman = null;
    $(document).ready(function(){
        gridman = $('#sites-data-table').gridman({
            controller: '/admin/rest/sites',
            model: 'sites',
            actions: 'edit|delete',
            columns: [{
                title: 'ИД',
                key: 'id'
            },{
                title: 'Домен',
                key: 'domain'
            },{
                title: 'Владелец',
                key: 'user_email',
                renderer: function(value, record){
                    return '<a href="#'+record.user_id+'">'+value+'</a>';
                }
            },{
                title: 'Блокировки',
                renderer: function(value, record){
                    var userBl  = record.user_blocked  > 0 ? 'да' : 'нет';
                    var adminBl = record.admin_blocked > 0 ? 'да' : 'нет';
                    return userBl + ' / ' + adminBl;
                }
            }],
            events: {
                onPressAddingBtn: function(){},
                onPressRowButtonEdit: function(){}
            }
        });
    });
</script>

<div style="height: 30px"></div>

<table class="table" id="sites-data-table">
    <!-- grid -->
</table>