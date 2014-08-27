<div class="row" style="margin: 15px 0 15px;">

    <div class="col-md-3">
        <h3 style="margin: 0;">{{ $title }}</h3>
    </div>

    <div class="col-md-9">

    <?
    echo \Widget\Grid::controls([
        'group_box' => isset($group_box) ? $group_box : false,
        'target'    => $target
    ]);
    ?>

    </div>

</div>

<? if (isset($columns)) { ?>
<table class="table table-bordered" data-target="{{ $target }}" data-columns="{{ implode(',', array_keys($columns)) }}"<?= isset($column_renderer) ? ' data-columnrenderer="'.$column_renderer.'"' : '' ?>>
    <thead>
    <tr>
    <? foreach ($columns as $column) { ?>
        <th>{{ $column }}</th>
    <? } ?>
    </tr>
    </thead>
    <tbody>
    <? if (isset($rows)) { foreach ($rows as $row) { ?>
        <tr>
        <? foreach (array_keys($columns) as $field) { ?>
            <td><?= $row->$field ?></td>
        <? } ?>
        </tr>
    <? } } else { ?>
        <tr><td class="empty-row text-center" colspan="<?= count($columns) ?>"><em>Нет данных для отображения</em></td></tr>
    <? } ?>
    </tbody>
<? } else { ?>
<table class="table table-bordered" data-target="{{ $target }}">
    <tbody>
    </tbody>
<? } ?>
</table>
<div style="text-align: center; margin-top: -30px;" class="grid-pagination" data-target="{{ $target }}">
</div>