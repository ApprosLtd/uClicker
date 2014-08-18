<div class="row">
  <div class="col-md-3">
    <a href="/collections" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list"></span> Список спарвочников</a>
    <a href="/collections/edit/{{ $source_name }}?modify=0" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span> Добавить</a>
  </div>
  <div class="col-md-9"><h3 style="margin: 3px 0 0;">{{ $title or '' }}</h3></div>
</div>

{{ $grid }}

<table class="table" id="collection-data-table">
    <!-- grid -->
</table>

<script>
$('#collection-data-table').gridman({
    controller: '/admin/rest/collections',
    model: '{{ $source_name }}',
    columns: [{
        title: 'ИД',
        key: 'id'
    },{
        title: 'Наименование',
        key: 'title'
    },{
        title: 'Цвет',
        key: 'color',
        renderer: function(value, record){
            return '<div style="height: 20px; width: 20px; color: '+value+'"></div>';
        }
    }]
});
</script>