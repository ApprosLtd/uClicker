<script src="/packages/widget/grid.js"></script>

<div class="row" style="background: #F7F6F5; padding: 20px 0; margin-top: -15px; border-radius: 5px 5px 0 0; border-bottom: 1px solid #E6E6E6;">
  <div class="col-md-6">
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalAddSite">Пополнить баланс</button>
      <a class="btn btn-danger" href="/balance/replenishment?summ=100">+ 100р.</a>
  </div>
  <div class="col-md-3" style="text-align: right; padding-top: 6px; color:#646464"><h3 style="margin: 0;">Доступно средств:</h3></div>
  <div class="col-md-3" style="padding-top: 6px;"><h3 style="margin: 0;"><?= number_format($balance, 2) ?> <sup>руб.</sup></h3></div>
</div>

<div style="height: 20px;"></div>

<?
echo \Widget\Grid::render([
    'title'   => 'Пополнение счета',
    'target'  => 'balance_sheet',
    //'rows'    => $balance_sheet,
    'columns' => [
        'id'         => '#',
        'comment'    => 'Описание',
        'debit'      => 'Сумма, руб.',
        'created_at' => 'Дата/Время',
    ]
]);
?>
<script>
    loadGridData({
        from: 0,
        to: 0,
        target: 'balance_sheet',
        page: 1,
        container: 'table[data-target="balance_sheet"]'
    });
</script>

<div style="height: 50px;"></div>

<?
echo \Widget\Grid::render([
    'title'   => 'Расход средств',
    'target'  => 'balance_sheet_credit',
    'group_box' => true,
    //'rows'    => $balance_sheet_credit,
    'columns' => [
        'domain' => 'Сайт',
        'posts'  => 'Постов',
        'summa'  => 'Сумма, руб.',
    ]
]);
?>
<script>
    loadGridData({
        from: 0,
        to: 0,
        target: 'balance_sheet_credit',
        page: 1,
        container: 'table[data-target="balance_sheet_credit"]'
    });
</script>

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

