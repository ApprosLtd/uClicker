<div class="row">
  <div class="col-md-3">
    <div class="list-group">
    <? foreach ($menu as $menu_item) { 
        $active = ($menu_item['href'] == $current) ? ' active' : '';
        ?>
        <a href="/help/{{ $menu_item['href'] }}" class="list-group-item{{ $active }}">{{ $menu_item['text'] }}</a>
    <? } ?>
    </div>
  </div>
  <div class="col-md-9">{{ $markdown }}</div>
</div>