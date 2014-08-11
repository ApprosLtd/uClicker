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
      <input type="text" data-target="BalanceSheet-from" class="datepicker" style="width: 80px" valuse="">
      до
      <input type="text" data-target="BalanceSheet-to" class="datepicker" style="width: 80px" valuse="">
    </div>

    <span style="font-size: 13px; padding: 0 5px;">или</span>

    <div class="btn-group btn-group-xs">
      <button type="button" class="btn btn-default" data-target="BalanceSheet" data-period="today">Сегодня</button>
      <button type="button" class="btn btn-default" data-target="BalanceSheet" data-period="yesterday">Вчера</button>
      <button type="button" class="btn btn-default" data-target="BalanceSheet" data-period="week">Неделя</button>
      <button type="button" class="btn btn-default" data-target="BalanceSheet" data-period="month">Месяц</button>
      <button type="button" class="btn btn-default" data-target="BalanceSheet" data-period="quarter">Квартал</button>
      <button type="button" class="btn btn-default" data-target="BalanceSheet" data-period="year">Год</button>
    </div>

  </div>

</div>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>Описание</th>
      <th>Сумма, руб.</th>
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
      <th>Сайт</th>
      <th>Постов</th>
      <th>Сумма, руб.</th>
    </tr>
  </thead>
  <tbody>
  <?
      foreach ($balance_sheet_credit as $balance_operation) {
          ?>
    <tr>
      <td><?= $balance_operation->domain ?></td>
      <td><?= $balance_operation->posts ?></td>
      <td><?= $balance_operation->summa ?></td>
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
    onSelect: function(dateText, inst){
        var target = $(inst.input[0]).data('target');
        var fromDateStr, toDateStr;
        target = target.split('-');
        var dr = target[1];
        target = target[0];
        if (dr=='from') {
            fromDateStr = dateText;
            toDateStr   = $('input[data-target="'+target+'-to"]').val();
        } else if (dr=='to') {
            fromDateStr = $('input[data-target="'+target+'-from"]').val();
            toDateStr   = dateText;
        }
        loadData(fromDateStr, toDateStr, target);
    }
  });

  $('[data-period]').on('click', function(){
      var target   = $(this).data('target');
      var currentDate = new Date();

      var fromDate = new Date();

      switch ($(this).data('period')) {
          case 'today':
              fromDate = new Date();
              break;
          case 'yesterday':
              fromDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()-1);
              break;
          case 'week':
              fromDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate()-7);
              break;
          case 'month':
              fromDate = new Date(currentDate.getFullYear(), currentDate.getMonth()-1, currentDate.getDate());
              break;
          case 'quarter':
              fromDate = new Date(currentDate.getFullYear(), currentDate.getMonth()-3, currentDate.getDate());
              break;
          case 'year':
              fromDate = new Date(currentDate.getFullYear()-1, currentDate.getMonth(), currentDate.getDate());
              break;
      }

      var fromDateStr = fromDate.getDate()+'.'+(fromDate.getMonth()+1)+'.'+fromDate.getFullYear();
      var toDateStr   = currentDate.getDate()+'.'+(currentDate.getMonth()+1)+'.'+currentDate.getFullYear();

      $('[data-target="'+target+'-from"]').datepicker('setDate', fromDateStr);
      $('[data-target="'+target+'-to"]').datepicker('setDate', toDateStr);

      loadData(fromDateStr, toDateStr, target);
  });

  function loadData(from, to, target, page){
      if (!page) page = 1;
      $.ajax({
          url: '/data',
          dataType: 'json',
          type: 'post',
          data: {
              from_date: from,
              to_date: to,
              target: target,
              page: page
          },
          success: function(data){
              //
          }
      });
  }

</script>