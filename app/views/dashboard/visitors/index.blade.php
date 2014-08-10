<table class="table table-hover">
    <thead>
    <tr>
        <th>Посетитель</th>
        <th style="width: 200px">Постов</th>
        <th style="width: 200px">Соц.сеть</th>
        <!--th style="width: 270px"></th-->
    </tr>
    </thead>
    <tbody>
    <?
    foreach ($visitors as $visitor) {
        ?>
        <tr>
            <td><a href="#" data-toggle="modal" data-target="#visitorInformation" onclick="visitorInfo(<?= $visitor->id ?>); return false;"><?= $visitor->first_name . ' ' . $visitor->last_name ?></a></td>
            <td><?= $visitor->quests ?></td>
            <td><?= $visitor->vendor ?></td>
            <!--td>  
                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#visitorInformation" onclick="visitorInfo(<?= $visitor->id ?>)">подробнее</button>
                <? if ($visitor->blocked) { ?>
                    <button type="button" class="btn btn-default btn-xs" onclick="visitorUnblocking(<?= $visitor->id ?>)" title="разблокировать">разблок-вать</button>
                <? } else { ?>
                    <button type="button" class="btn btn-warning btn-xs" onclick="visitorBlocking(<?= $visitor->id ?>)">блокировать</button>
                <? } ?> 
            </td-->
        </tr>
    <?
    }
    ?>
    </tbody>
</table>

<div class="modal fade" id="visitorInformation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                <h4 class="modal-title">Информация о посетителе</h4>
            </div>
            <div class="modal-body">

                <a href="http://vk.com/id<?= $visitor->uid ?>" target="_blank">Посетитель</a>

            </div>
        </div>
    </div>
</div>