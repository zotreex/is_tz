<html>
<head>
    <meta charset="utf-8">
    <title>Главная страница</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Статистика корзин'],
            ['Оплачено',     <?= (int)$paid?>],
            ['Брошено',      <?= (int)$unpaid?>]
        ]);

        var options = {
            legend: 'none',
            enableInteractivity: false,
            pieHole: 0.4,
            slices: {
                0: {color: '#17a2b8'},
                1: {color: '#FF891C'}
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    }
</script>
<div class="container">
    <?php
    require 'menu.view.php';
    ?>
    <div class="row justify-content-md-center">

        <div class="col-12 col-md-12">
            <div class="row">


                <?php
                if ($flag) {
                    // $db_check = $db->getAll("select * from carts where date_open between ?s and ?s and date_close is NULL", $_POST['from'], $_POST['to']);

                    echo "<div id='donutchart' class='col-12 col-md-4 offset-md-2' style='height: 20em'></div>";

                    echo "<div class='col-12 col-md-6 ' ><table style='height: 100%;'><tr><td class=\"align-middle\"><span> Оплачено: $paid (" . round(100 / ((int)$paid + (int)$unpaid) * $paid, 1) . "%)<br>";
                    echo "Брошено: $unpaid (" . round(100 / ((int)$paid + (int)$unpaid) * $unpaid, 1) . "%)</span></td></tr></table> </div>";

                }

                ?>
            </div>
        </div>
        <div>
            <p>Выберите нужный интервал: </p>
            <form action="index.php?page=carts" method="post">
                <div class="form-inline">
                    <input id="datetime" class="form-control" name="from" type="datetime-local"
                           value="<?php echo $last_string_m->format('Y-m-d') . 'T' . $last_string_m->format('H:i') ?>">
                    <input id="datetime " class="form-control" name="to" type="datetime-local"
                           value="<?php echo $last_string->format('Y-m-d') . 'T' . $last_string->format('H:i') ?>">

                </div>
                <input type="submit" style="width: 100%; margin-top: 1em" class="btn btn-outline-info"
                       value="Отправить">
            </form>
        </div>


    </div>
</div>
</body>

<script src="js/jq.js"></script>
<script src="js/bootstrap.min.js"></script>

</html>