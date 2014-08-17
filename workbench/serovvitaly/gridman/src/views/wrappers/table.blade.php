@if ($attach_jquery_plugin)
<script type="text/javascript" src="/packages/gridman/jquery.gridman.js"></script>
@endif

<table class="table" id="{{ $id }}">
  <thead>
    <tr>
      @foreach ($columns as $column)
      <th>{{ $column->title }}</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    <!-- items -->
  </tbody>
</table>

<script type="text/javascript">
$(document).ready(function(){
    $('#{{ $id }}').gridman();
});
</script>