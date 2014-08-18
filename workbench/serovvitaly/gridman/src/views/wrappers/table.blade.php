@if ($attach_jquery_plugin)
<link rel="stylesheet" href="/packages/gridman/gridman.css">
<script type="text/javascript" src="/packages/gridman/jquery.gridman.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    //$('.gridman-grid').gridman();
});
</script>
@endif

<?
$columns_content = '';
$widgets = [];
foreach ($columns as $column) {
    $columns_content .= '<th>'.$column->title.'</th>';
    $columns_keys[] = $column->key;

    if (isset($column->widget) and !empty($column->widget)) {
        $widgets[] = $column->key . ':' . $column->widget;
    }
}
?>

<table class="table gridman-grid" id="{{ $id }}" data-columns="{{ implode(',', $columns_keys) }}" data-source="{{ $source_name }}" data-widgets="{{ implode(',', $widgets) }}">
  <thead>
    <tr><td colspan="{{ count($columns) }}">
        Верхняя навигация
    </td></tr>
  </thead>
  <thead>
    <tr>
      {{ $columns_content }}
    </tr>
  </thead>
  <tbody>
      <!-- items -->
  </tbody>
  <tfoot>
    <tr><td colspan="{{ count($columns) }}">
        @include('gridman::toolbars.nav')
    </td></tr>
  </tfoot>
</table>

