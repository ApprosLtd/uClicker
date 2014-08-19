@if ( $source_name == 'priorities' )
<script>
    var columns = [{
        title: 'ИД',
        key: 'id'
    },{
        title: 'Наименование',
        key: 'title'
    },{
        title: 'Цвет',
        key: 'color',
        renderer: function(value, record){
            if (!value) return 'нет';
            return '<div style="height: 20px; width: 20px; background-color: '+value+'"></div>';
        }
    }];
</script>
@else
<script>
    var columns = [{
        title: 'ИД',
        key: 'id'
    },{
        title: 'Наименование',
        key: 'title'
    }];
</script>
@endif

<script>
function saveEditForm(grid){
    var commonModal = $('#common-modal');
    var parent = $(this).parents('.modal-content')[0];
    var titleField  = $(parent).find('input[name="title"]');
    var title = titleField.val();
    var colorField  = $(parent).find('input[name="color"]');
    var color = colorField.val();
    var error = false;
    if (title == '') {
        titleField.parents('.form-group').addClass('has-error');
        error = true;
    }
    if (color == '') {
        colorField.parents('.form-group').addClass('has-error');
        error = true;
    }
    if (error) return;
    grid.saveRecord({
        title: title,
        color: color
    }, function(){
        commonModal.modal('hide');
    });
}
function onPressAddingBtn(grid){
    var commonModal = $('#common-modal');
    var source = $('#{{ $modal_body_template }}').html();
    commonModal.find('div.modal-body').html(Handlebars.compile(source));
    commonModal.find('.modal-button-save').unbind('click').on('click', function(){
        saveEditForm(grid);
    });
    commonModal.modal('show');

    var colorField = commonModal.find('input[name="color"]');
    if (colorField.length > 0) {
        colorField.minicolors({
            opacity: false,
            inline: false,
            defaultValue: '#c92424'
        });
    }
}
function onPressEditBtn(grid, index){
    var commonModal = $('#common-modal');
    var source = $('#{{ $modal_body_template }}').html();
    commonModal.find('div.modal-body').html(Handlebars.compile(source));
    commonModal.find('.modal-button-save').unbind('click').on('click', function(){
        saveEditForm(grid);
    });
    commonModal.modal('show');

    var colorField = commonModal.find('input[name="color"]');
    if (colorField.length > 0) {
        colorField.minicolors({
            opacity: false,
            inline: false,
            defaultValue: '#c92424'
        });
    }
}
var gridman = null;
$(document).ready(function(){
    gridman = $('#collection-data-table').gridman({
        controller: '/admin/rest/collections',
        model: '{{ $source_name }}',
        actions: 'edit|delete',
        columns: columns,
        events: {
            onPressAddingBtn: onPressAddingBtn,
            onPressRowButtonEdit: onPressEditBtn
        }
    });
});
</script>

<!-- Content -->
<div class="row">
    <div class="col-md-7"><h3 style="margin: 3px 0 0;">{{ $title or '' }}</h3></div>
    <div class="col-md-5" style="text-align: right">
        <a href="/collections" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list"></span> Список спарвочников</a>
        <div class="btn-group btn-group-sm">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Быстрый переход <span class="caret"></span></button>
          <ul class="dropdown-menu dropdown-menu-right" role="menu">
              <li><a href="/collections?source=categories">Категории тикетов (тех. поддержка)</a></li>
              <li><a href="/collections?source=priorities">Приоритеты тикетов (тех. поддержка)</a></li>
              <li><a href="/collections?source=statuses">Статусы тикетов (тех. поддержка)</a></li>
          </ul>
        </div>
        <!--a href="#" class="btn btn-primary btn-sm" onclick="onPressAddingBtn(gridman); return false;"><span class="glyphicon glyphicon-plus"></span> Добавить</a-->
    </div>

</div>


<script type="text/javascript" src="/packages/handlebars/handlebars-v1.3.0.js"></script>

<link rel="stylesheet" href="/packages/minicolors/jquery.minicolors.css">
<script type="text/javascript" src="/packages/minicolors/jquery.minicolors.min.js"></script>

<link rel="stylesheet" href="/packages/gridman/gridman.css">
<script type="text/javascript" src="/packages/gridman/jquery.gridman.js"></script>

<div style="height: 30px"></div>

<table class="table" id="collection-data-table">
    <!-- grid -->
</table>

<!-- Modal -->
<div class="modal fade bs-example-modal-sm" id="common-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">{{ $modal_title }}</h4>
            </div>
            <div class="modal-body">
                <!-- boby -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary modal-button-save">Сохранить</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

<!-- Templates -->
<script id="common-template-1" type="text/x-handlebars-template">
    <form role="form">
        <div class="form-group">
            <label>Наименование</label>
            <input type="text" class="form-control" name="title" placeholder="Наименование">
        </div>
    </form>
</script>
<script id="common-template-2" type="text/x-handlebars-template">
    <form role="form">
        <div class="form-group">
            <label>Наименование</label>
            <input type="text" class="form-control" name="title" placeholder="Наименование">
        </div>
        <div class="form-group">
            <div><label>Цвет</label></div>
            <input type="text" class="form-control" name="color" placeholder="Цвет">
        </div>
    </form>
</script>