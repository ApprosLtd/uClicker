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

<? if (isset($group_box) and $group_box == true) { ?>
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
<? } ?>