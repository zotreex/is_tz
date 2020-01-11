<?php
$last_string = new DateTime($db->getOne("select max(date) from visitors"));
$last_string_m  =  new DateTime($db->getOne("select max(date) from visitors"));
$last_string_m->modify('-12 hours');
if (!empty($_POST['from']) && !empty($_POST['to'])) {

    $from = htmlspecialchars($_POST['from']);
    $to = htmlspecialchars($_POST['to']);


    $from = new DateTime($from);
    $to = new DateTime($to);

    $flag = true;
    $unpaid = $db->getOne("select count(*) from carts where date_open between ?s and ?s and date_close is NULL", $from->format('Y-m-d H:i:s'), $to->format('Y-m-d H:i:s'));
    $paid = $db->getOne("select count(*) from carts where date_open between ?s and ?s and date_close is not NULL", $from->format('Y-m-d H:i:s'), $to->format('Y-m-d H:i:s'));
    if ($unpaid == 0) {
        $flag = false;
    }
}

require 'views/carts.view.php';