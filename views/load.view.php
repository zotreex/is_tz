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
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Время', 'Запросов за час'],
            <?php foreach ($answer as $key => $value): ?>
            ['<?=$key?>', <?=$value?>],
            <?php endforeach; ?>
        ]);

        var options = {
            title: 'Нагрузка за час',
            legend: 'none',
            vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
<div class="container">
    <?php
    require 'menu.view.php';
    ?>
    <div class="row justify-content-md-center">

        <div class="col-12 col-md-8 ">
            <div class="row">
                <?php if ($flag): ?>
                    <div id="chart_div" style="width: 100%; height: 500px;"></div>

                <?php endif; ?>

            </div>
        </div>
        <div>
            <?php
            if (!$flag && !empty($_POST['from']))
                echo "<div class='alert alert-warning' style='margin-top: 1em'>" . $error_msg . "</div>";
            ?>
            <p>Выберите нужный интервал: </p>

            <form action="index.php?page=load" method="post">
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