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