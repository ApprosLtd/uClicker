<div class="row" style="background: #F7F6F5; padding: 20px 0; margin-top: -15px; border-radius: 5px 5px 0 0; border-bottom: 1px solid #E6E6E6;">
  <div class="col-md-6">
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalAddSite">Пополнить баланс</button>
      <a class="btn btn-danger" href="/balance/replenishment?summ=100">+ 100р.</a>
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
      от 
      <input type="text" id="account-replenishment-from" class="datepicker" style="width: 80px" valuse="">
      до
      <input type="text" id="account-replenishment-to" class="datepicker" style="width: 80px" valuse="">
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
  <?
      foreach ($balance_sheet as $balance_operation) {
          ?>
    <tr>
      <td><?= $balance_operation->id ?></td>
      <td><?= $balance_operation->comment ?></td>
      <td><?= $balance_operation->debet ?></td>
      <td><?= $balance_operation->created_at ?></td>
    </tr>
          <?
      }
  ?>
  </tbody>
</table>

<div style="height: 50px;"></div>

<div class="row" style="margin: 15px 0 15px;">

<div class="col-md-3">
    <h3 style="margin: 0;">Расход средств</h3>
</div>

<div class="col-md-9">

    <div class="btn-group btn-group-xs">
      от 
      <input type="text" id="discharge-funds-from" class="datepicker" style="width: 80px" valuse="">
      до
      <input type="text" id="discharge-funds-to" class="datepicker" style="width: 80px" valuse="">
    </div>

    <span style="padding: 0 5px;">или</span>

    <div class="btn-group btn-group-xs">
      <button type="button" class="btn btn-default">Сегодня</button>
      <button type="button" class="btn btn-default">Вчера</button>
      <button type="button" class="btn btn-default">Неделя</button>
      <button type="button" class="btn btn-default">Месяц</button>
      <button type="button" class="btn btn-default">Квартал</button>
      <button type="button" class="btn btn-default">Год</button>
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
                <h4 class="modal-title">Пополнение баланса</h4>
            </div>
            <div class="modal-body">

                <iframe src="https://www.avangard.ru/iacq/faces/facelet-pages/pay.xhtml" style="width: 598px; margin: -15px; border: none; height: 510px;"></iframe>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $('.datepicker').datepicker({
    dateFormat: 'dd.mm.yy',
    changeMonth: true,
    changeYear: true,
    onSelect: function(){
      //
    }
  });
</script>