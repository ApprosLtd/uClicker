<div class="row" style="background: #F7F6F5; padding: 20px 0; margin-top: -15px; border-radius: 5px 5px 0 0; border-bottom: 1px solid #E6E6E6;">
  <div class="col-md-6">
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalAddSite">Пополнить баланс</button>
  </div>
  <div class="col-md-3" style="text-align: right; padding-top: 6px; color:#646464"><h3 style="margin: 0;">Доступно средств:</h3></div>
  <div class="col-md-3" style="padding-top: 6px;"><h3 style="margin: 0;"><?= number_format(2000.67, 2) ?> <sup>руб.</sup></h3></div>
</div>

<h3>Расход средств</h3>

<div style="margin: 5px 0 15px; float: right;">

<div class="btn-group btn-group-xs">
  <button type="button" class="btn btn-default">12.07.2014 - 15.12.2014</button>
</div>

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

<script src="/packages/chartjs/Chart.min.js"></script>

<canvas id="myChart" width="1140" height="400"></canvas>

<script>
    var ctx = document.getElementById("myChart").getContext("2d");


    var data = {
        labels: ["January", "February", "March", "April", "May", "June", "July", "February", "March", "April", "May", "June", "July", "February", "March", "April", "May", "June", "July"],
        datasets: [
            {
                label: "My First dataset",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [65, 59, 80, 81, 56, 55, 40, 59, 80, 81, 56, 55, 40, 59, 80, 81, 56, 55, 40]
            },
            {
                label: "My Second dataset",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [28, 48, 40, 19, 86, 27, 90, 48, 40, 19, 86, 27, 90, 48, 40, 19, 86, 27, 90]
            }
        ]
    };


    var myLineChart = new Chart(ctx).Line(data, {

        ///Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines : true,

        //String - Colour of the grid lines
        scaleGridLineColor : "rgba(0,0,0,.05)",

        //Number - Width of the grid lines
        scaleGridLineWidth : 1,

        //Boolean - Whether the line is curved between points
        bezierCurve : true,

        //Number - Tension of the bezier curve between points
        bezierCurveTension : 0.4,

        //Boolean - Whether to show a dot for each point
        pointDot : true,

        //Number - Radius of each point dot in pixels
        pointDotRadius : 4,

        //Number - Pixel width of point dot stroke
        pointDotStrokeWidth : 1,

        //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
        pointHitDetectionRadius : 20,

        //Boolean - Whether to show a stroke for datasets
        datasetStroke : true,

        //Number - Pixel width of dataset stroke
        datasetStrokeWidth : 2,

        //Boolean - Whether to fill the dataset with a colour
        datasetFill : true,

        //String - A legend template
        legendTemplate : ""

    });
</script>