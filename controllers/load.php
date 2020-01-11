<?php

$last_string = new DateTime($db->getOne("select max(date) from visitors"));

$last_string_m  = new DateTime($db->getOne("select max(date) from visitors"));
$last_string_m->modify('-12 hours');


if (!empty($_POST['from']) && !empty($_POST['to'])) {
    $from = htmlspecialchars($_POST['from']);
    $to = htmlspecialchars($_POST['to']);
    $flag = true;

    $step = new DateTime($from);
    $from = new DateTime($from);

    $step->modify('+1 hour');
    $to = new DateTime($to);

    $error_msg = "Введите корректную дату";

    if ($from == $to || $from > $to) $flag = false;

    $diff = $to->diff($from);

    $hours = $diff->h;
    $hours = $hours + ($diff->days * 24);

    if ($hours > 24) {
        $error_msg = "Слишком большой интервал (максимум 24 часа)<br>" . $error_msg;
        $flag = false;
    }
    $answer = array();
    if ($hours > 0 && $hours <= 24) {
        for ($i = 0; $i < $hours; $i++) {
            $query = $db->getOne("select count(*) from visitors where date between ?s and ?s", $from->format('Y-m-d H:i:s'), $step->format('Y-m-d H:i:s'));
            $step->modify('+1 hour');
            $from->modify('+1 hour');
            $answer[$from->format('H:i')] = $query;
        }
    }
    // $d->modify( '+1 hour' );


    /*   $hours_between = round(($to-$from)/3600);
       $unpaid = $db->getOne("select count(*) from carts where date_open between ?s and ?s and date_close is NULL", $_POST['from'], $_POST['to']);
       $from_step = $from+3600;
       $query = $db->getOne("select count(*) from visitors where date between ?s and ?s", strtotime($from),strtotime($from_step));
       $from = $from_step;
   */

}
require 'views/load.view.php';