<div class="row" style="background: #F7F6F5; padding: 20px 0; margin-top: -15px; border-radius: 5px 5px 0 0; border-bottom: 1px solid #E6E6E6;">
  <div class="col-md-6">
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalAddSite">Пополнить баланс</button>
  </div>
  <div class="col-md-3" style="text-align: right; padding-top: 6px; color:#646464"><h3 style="margin: 0;">Доступно средств:</h3></div>
  <div class="col-md-3" style="padding-top: 6px;"><h3 style="margin: 0;"><?= number_format($balance, 2) ?> <sup>руб.</sup></h3></div>
</div>

<div style="height: 20px;"></div>

<div class="row" style="margin: 15px 0 15px;">

  <div class="col-md-3">
    <h3 style="margin: 0;">Пополнение счета</h3>
  </div>

  <div class="col-md-9">

    <div class="btn-group btn-group-xs">
      <button type="button" class="btn btn-default">12.07.2014 - 15.12.2014</button>
    </div>

    <span style="font-size: 13px; padding: 0 5px;">или</span>

    <div class="btn-group btn-group-xs">
      <button type="button" class="btn btn-default">Сегодня</button>
      <button type="button" class="btn btn-default">Вчера</button>
      <button type="button" class="btn btn-default">Неделя</button>
      <button type="button" class="btn btn-default">Месяц</button>
      <button type="button" class="btn btn-default">Квартал</button>
      <button type="button" class="btn btn-default">Год</button>
    </div>

  </div>

</div>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>Описание</th>
      <th>Сумма</th>
      <th>Дата/Время</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Mark</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@TwBootstrap</td>
    </tr>
    <tr>
      <td>3</td>
      <td>3</td>
      <td>Larry the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>

<div style="height: 50px;"></div>

<div class="row" style="margin: 15px 0 15px;">

<div class="col-md-3">
    <h3 style="margin: 0;">Расход средств</h3>
</div>

<div class="col-md-9">

    <div class="btn-group btn-group-xs">
      <button type="button" class="btn btn-default" onclick="$('#discharge-funds-from').datepicker('show');">12.07.2014 - 15.12.2014</button>
      <input type="text" id="discharge-funds-from" valuse="">
      <input type="text" id="discharge-funds-to" valuse="">
    </div>

    <span style="font-size: 13px; padding: 0 5px;">или</span>

    <div class="btn-group btn-group-xs">
      <button type="button" class="btn btn-default">Сегодня</button>
      <button type="button" class="btn btn-default">Вчера</button>
      <button type="button" class="btn btn-default">Неделя</button>
      <button type="button" class="btn btn-default">Месяц</button>
      <button type="button" class="btn btn-default">Квартал</button>
      <button type="button" class="btn btn-default">Год</button>
    </div>

    <span style="font-size: 13px; padding-left: 20px;">Группировать по:</span>

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

<table class="table table-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>Описание</th>
      <th>Сумма</th>
      <th>Дата/Время</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Mark</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@TwBootstrap</td>
    </tr>
    <tr>
      <td>3</td>
      <td>3</td>
      <td>Larry the Bird</td>
      <td>@twitter</td>
    </tr>
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

<script type="text/javascript">
  $('#discharge-funds-from').datepicker();
</script>