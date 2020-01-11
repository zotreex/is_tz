<?php

$last_string = new DateTime($db->getOne("select max(date) from visitors"));

$last_string_m  =  new DateTime($db->getOne("select max(date) from visitors"));
$last_string_m->modify('-12 hours');

if (!empty($_POST['from']) && !empty($_POST['to'])) {
    $from = htmlspecialchars($_POST['from']);
    $to = htmlspecialchars($_POST['to']);

    $flag = true;

    $from = new DateTime($from);
    $to = new DateTime($to);

    $query = $db->getOne("
        SELECT COUNT(*) as ans FROM `carts` where 
        user in(
        Select user from `carts` where 
        date_close BETWEEN ?s and ?s
        GROUP by user HAVING COUNT(cart_id)=1)
    ", $from->format('Y-m-d H:i:s'), $to->format('Y-m-d H:i:s'));

    $first_buy = $query;
    $second_buy = $db->getOne("
        SELECT COUNT(*) as ans FROM `carts` where 
        user in(
        Select user from `carts` where 
        date_close BETWEEN ?s and ?s
        GROUP by user HAVING COUNT(cart_id)=2)
    ", $from->format('Y-m-d H:i:s'), $to->format('Y-m-d H:i:s'));;
    $third_buy = $db->getOne("
        SELECT COUNT(*) as ans FROM `carts` where 
        user in(
        Select user from `carts` where 
        date_close BETWEEN ?s and ?s
        GROUP by user HAVING COUNT(cart_id)>2)
    ", $from->format('Y-m-d H:i:s'), $to->format('Y-m-d H:i:s'));;

} else {
    $flag = false;
}
require 'views/repeat.view.php';