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
    google.charts.load("current", {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Element', 'Количество'],
            ['Первая покупка', <?=$first_buy?>],
            ['Вторая покупка',<?=$second_buy?>],
            ['Третья', <?=$third_buy?>],
        ]);
        var options = {
            title: "Количество покупок за период",
            bar: {groupWidth: '95%'},
            legend: {position: 'none'},
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_plain'));
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
                <div class="spinner-grow text-info mx-auto" id="loads" style="display: none; height: 7em; width: 7em"
                     role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <?php if ($flag): ?>
                    <div id="columnchart_plain" style="display: block;width: 900px; height: 300px;"></div>

                <?php endif; ?>

            </div>
        </div>
        <div>
            <?php
            if (!$flag && !empty($_POST['from']))
                echo "<div class='alert alert-warning' style='margin-top: 1em'>" . $error_msg . "</div>";
            ?>
            <p>Выберите нужный интервал: </p>

            <form action="index.php?page=repeat" method="post">
                <div class="form-inline">
                    <input id="datetime" class="form-control" name="from" type="datetime-local"
                           value="<?php echo $last_string_m->format('Y-m-d') . 'T' . $last_string_m->format('H:i') ?>">
                    <input id="datetime " class="form-control" name="to" type="datetime-local"
                           value="<?php echo $last_string->format('Y-m-d') . 'T' . $last_string->format('H:i') ?>">

                </div>
                <input type="submit" id="hider" style="width: 100%; margin-top: 1em" class="btn btn-outline-info"
                       value="Отправить">
            </form>
        </div>


    </div>
</div>
</body>
<script>
    // Здесь не важно, как мы скрываем текст.
    // Также можно использовать style.display:
    document.getElementById('hider').onclick = function () {
        document.getElementById('loads').style.display = "block";
        document.getElementById('columnchart_plain').style.display = "none";


    }
</script>
<script src="js/jq.js"></script>
<script src="js/bootstrap.min.js"></script>

</html>