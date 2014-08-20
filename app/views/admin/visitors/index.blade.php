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
        gridman = $('#visitors-data-table').gridman({
            controller: '/admin/rest/visitors',
            model: 'visitors',
            actions: 'edit|delete',
            columns: [{
                title: 'ИД',
                key: 'id'
            },{
                title: 'Имя',
                renderer: function(value, record){
                    return record.first_name + ' ' + record.last_name;
                }
            },{
                title: 'Сеть',
                key: 'vendor',
                renderer: function(val) {
                    return 'Вконтакте';
                }
            },{
                title: 'Сеть ИД',
                key: 'uid'
            }],
            events: {
                onPressAddingBtn: function(){},
                onPressRowButtonEdit: function(){}
            }
        });
    });
</script>

<div style="height: 30px"></div>

<table class="table" id="visitors-data-table">
    <!-- grid -->
</table>