<div class="row" style="margin: 15px 0 15px;">

    <div class="col-md-3">
        <h3 style="margin: 0;">{{ $title }}</h3>
    </div>

    <div class="col-md-9">

        <div class="btn-group btn-group-xs">
            от
            <input type="text" data-target="{{ $target }}-from" class="grid-datepicker" style="width: 80px" valuse="">
            до
            <input type="text" data-target="{{ $target }}-to" class="grid-datepicker" style="width: 80px" valuse="">
        </div>

        <span style="font-size: 13px; padding: 0 5px;">или</span>



        <div class="btn-group btn-group-xs">
            <button type="button" class="btn btn-default" data-target="{{ $target }}" data-period="today">Сегодня</button>
            <button type="button" class="btn btn-default" data-target="{{ $target }}" data-period="yesterday">Вчера</button>
            <button type="button" class="btn btn-default" data-target="{{ $target }}" data-period="week">Неделя</button>
            <button type="button" class="btn btn-default" data-target="{{ $target }}" data-period="month">Месяц</button>
            <button type="button" class="btn btn-default" data-target="{{ $target }}" data-period="quarter">Квартал</button>
            <button type="button" class="btn btn-default" data-target="{{ $target }}" data-period="year">Год</button>
            <button type="button" class="btn btn-primary" data-target="{{ $target }}" data-period="today">Все</button>

        </div>

        <span style="padding-left: 20px;">Группировать по:</span>

        <div class="btn-group btn-group-xs">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                Дням
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="#">Дням</a></li>
                <li><a href="#">Неделям</a></li>
                <li><a href="#">Месяцам</a></li>
            </ul>

        </div>

    </div>

</div>

<table class="table table-bordered" data-target="{{ $target }}" data-columns="{{ implode(',', array_keys($columns)) }}">
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
</table>
<div style="text-align: center; display: block;">
    <ul class="pagination pagination-sm" style="margin-top: -10px;" data-target="{{ $target }}">
        <li><a href="#">«</a></li>
        <li><a href="#">1</a></li>
        <li class="active"><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">»</a></li>
    </ul>
</div>