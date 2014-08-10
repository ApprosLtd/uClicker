<table class="table table-hover">
    <thead>
    <tr>
        <th>Домен</th>
        <th style="width: 200px">UID</th>
        <th>Комментарий</th>
        <th style="width: 270px"></th>
    </tr>
    </thead>
    <tbody>
    <?
    foreach ($visitors as $visitor) {
        ?>
        <tr>
            <td><a href="<?= $visitor->domain ?>" target="_blank"><?= $visitor->domain ?></a></td>
            <td><?= $site->id ?></td>
            <td><?= $site->comment ?></td>
            <td>
                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalAddSite" onclick="formFilling(<?= $site->id ?>)">редактировать</button>
                <? if ($site->blocked) { ?>
                    <button type="button" class="btn btn-default btn-xs" onclick="siteUnblocking(<?= $site->id ?>)" title="разблокировать">разблок-вать</button>
                <? } else { ?>
                    <button type="button" class="btn btn-warning btn-xs" onclick="siteBlocking(<?= $site->id ?>)">блокировать</button>
                <? } ?>
                <button type="button" class="btn btn-danger btn-xs"  onclick="siteRemove(<?= $site->id ?>)">удалить</button>
            </td>
        </tr>
    <?
    }
    ?>
    </tbody>
</table>