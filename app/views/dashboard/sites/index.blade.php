<p>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAddSite" onclick="formFilling(0)">Добавить сайт</button>
</p>

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
    foreach ($sites as $site) {
    ?>
        <tr>
            <td><a href="<?= $site->domain ?>" target="_blank"><?= $site->domain ?></a></td>
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


<div class="modal fade" id="modalAddSite" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                <h4 class="modal-title">Новый сайт</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" role="form">
                    <input type="hidden" id="site-id" value="0">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">HTTP:// <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">HTTP://</a></li>
                                        <li><a href="#">HTTPS://</a></li>
                                    </ul>
                                </div><!-- /btn-group -->
                                <input type="text" class="form-control" placeholder="Домен" id="site-domain">
                            </div><!-- /input-group -->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <textarea class="form-control" rows="3" placeholder="Комментарий" id="site-comment"></textarea>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="siteSave()" disabled="disabled" id="site-button-save">Сохранить</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="formClear()">Отмена</button>
            </div>
        </div>
    </div>
</div>

<script>
    function siteSave(){

        var site_id = $('#site-id').val();
        var domain  = $('#site-domain').val();
        var comment = $('#site-comment').val();

        $.ajax({
            url: '/site/save',
            dateType: 'json',
            type: 'POST',
            data: {
                site_id: site_id,
                domain:  domain,
                comment: comment
            },
            success: function(data){
                window.location = window.location;
            }
        });

    }
    function siteBlocking(site_id){
        $.ajax({
            url: '/site/blocking',
            dateType: 'json',
            type: 'POST',
            data: {
                site_id: site_id
            },
            success: function(data){
                window.location = window.location;
            }
        });
    }
    function siteUnblocking(site_id){
        $.ajax({
            url: '/site/unblocking',
            dateType: 'json',
            type: 'POST',
            data: {
                site_id: site_id
            },
            success: function(data){
                window.location = window.location;
            }
        });
    }
    function siteRemove(site_id){

        if (!confirm('Будет удален сайт и все связанные с ним данные. Удалить?')) return;

        $.ajax({
            url: '/site/remove',
            dateType: 'json',
            type: 'POST',
            data: {
                site_id: site_id
            },
            success: function(data){
                window.location = window.location;
            }
        });
    }
    function formFilling(site_id){

        if (site_id < 1) {
            $('#site-id').val(0);
            $('#site-domain').val('');
            $('#site-comment').val('');
            $('#site-button-save').removeAttr('disabled');
            return;
        }

        $.ajax({
            url: '/site/get',
            dateType: 'json',
            type: 'POST',
            data: {
                site_id: site_id
            },
            success: function(data){
                $('#site-id').val(data.site_id);
                $('#site-domain').val(data.domain);
                $('#site-comment').val(data.comment);
                $('#site-button-save').removeAttr('disabled');
            }
        });
    }
    function formClear(){
        $('#site-id').val(0);
        $('#site-domain').val('');
        $('#site-comment').val('');
        $('#site-button-save').attr('disabled', 'disabled');
    }


    $('#modalAddSite').on('hide.bs.modal', function (e) {
        formClear();
    })

</script>