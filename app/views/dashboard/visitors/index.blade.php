<table class="table table-hover">
    <thead>
    <tr>
        <th>Посетитель</th>
        <th style="width: 200px">Соц.сеть</th>
        <th style="width: 270px"></th>
    </tr>
    </thead>
    <tbody>
    <?
    foreach ($visitors as $visitor) {
        ?>
        <tr>
            <td><a href="http://vk.com/id<?= $visitor->uid ?>" target="_blank"><?= $visitor->first_name . ' ' . $visitor->last_name ?></a></td>
            <td><?= $visitor->vendor ?></td>
            <td>
                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#visitorInformation" onclick="visitorInfo(<?= $visitor->id ?>)">подробнее</button>
                <? if ($visitor->blocked) { ?>
                    <button type="button" class="btn btn-default btn-xs" onclick="visitorUnblocking(<?= $visitor->id ?>)" title="разблокировать">разблок-вать</button>
                <? } else { ?>
                    <button type="button" class="btn btn-warning btn-xs" onclick="visitorBlocking(<?= $visitor->id ?>)">блокировать</button>
                <? } ?>
            </td>
        </tr>
    <?
    }
    ?>
    </tbody>
</table>