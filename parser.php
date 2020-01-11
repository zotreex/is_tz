<?php

$file_name = $log_file;
$array=file($file_name);
foreach ($array as $line){

    $u = array();
    /*ip*/ preg_match('/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}.[0-9]{1,3}/',$line,$ip);
    /*date*/ preg_match('/[0-9]{4}\-[0-9]{2}\-[0-9]{2}\s[0-9]{2}\:[0-9]{2}\:[0-9]{2}/',$line,$date);
    /*code*/ preg_match('/\[[a-zA-Z0-9]*\]/',$line,$code);
    /*url*/ preg_match('/(https):\/\/[a-zA-Z0-9_.\/\?=&]*/',$line,$url_match);
    $url = parse_url($url_match[0], PHP_URL_PATH);
   // echo $url . ' <br> ';
    switch ($url){
        case "/cart" :
           // echo "cart" . ' ';
            $db->query("INSERT INTO visitors SET ip = ?s, date = ?s, category = 'cart_page'", $ip[0], $date[0]);
            $parts = explode("&", parse_url($url_match[0], PHP_URL_QUERY));
            preg_match('/(?<=goods_id=)[0-9]{1,}/', $parts[0],$goods_id);
            preg_match('/(?<=amount=)[0-9]{1,}/', $parts[1],$amount);
            preg_match('/(?<=cart_id=)[0-9]{1,}/', $parts[2],$cart_id);
            $u['cart_id'] = $cart_id[0];
            $u['amount'] = (int)$amount[0];
            $u['product'] = (int)$goods_id[0];
            /*добавляем в корзину*/

            $db_check = $db->getRow("select cart_id from carts where cart_id = ?i", $cart_id[0]);
            if (empty($db_check['cart_id'])) {
                $db->query("INSERT INTO carts SET cart_id=?i, date_open=?s", $cart_id[0], $date[0]);
            }


            $db->query("INSERT INTO goods_in_carts SET ?u", $u);
            $db_check = $db->getRow("select name_prod from visitors where ip = ?s ORDER BY date DESC LIMIT 1", $ip[0]);
            /*на  основе id товара, запоминаем его в  таблице продуктов*/
            $db->query("update goods  SET id=?i where name = ?s", $u['product'], $db_check['name_prod']);

            break;

        case "/pay" :
           // echo "pay";
            $parts = explode("&", parse_url($url_match[0], PHP_URL_QUERY));
            preg_match('/(?<=user_id=)[0-9]{1,}/', $parts[0],$user_id);
            preg_match('/(?<=cart_id=)[0-9]{1,}/', $parts[1],$cart_id);
           // echo $user_id[0].' '.$cart_id[0];
            $u['user'] = $user_id[0];
            $u['cart'] = $cart_id[0];
            $u['date'] = $date[0];

            /*регистрируем оплату*/
            //    $db->query("update");
            // $db->query("insert into paid_orders set ?u", $u);
            // $order_id =  $db->insertId();


            $db->query("update carts set user = ?s where cart_id=?i and user is NULL", $user_id[0], $cart_id[0]);
            /*запоминаем пользователя и id заказа*/
            // $db->query("insert into users set id=?i, paid_orders = ?i", $u['user'], $order_id);
            break;

        case "/":
            $db->query("INSERT INTO visitors SET ip = ?s, date = ?s, category = 'main_page'", $ip[0], $date[0]);
            break;

        default :
            $parts = explode("/", $url);
            $cat = $parts[1];
            $subcat = $parts[2];

            preg_match('/(?<=success_pay_)[0-9]{1,}/', $cat,$check_cat);
            if (!empty($check_cat[0])) {
                $db->query("update carts set date_close = ?s where cart_id=?i and date_close is NULL", $date[0], $check_cat[0]);
               // echo "paid card number = " . $check_cat[0];
            } else {
                /*Обработка посещения раздела товаров*/
                $u['ip'] = $ip[0];
                $u['date'] = $date[0];
                $db_check = $db->getRow("select id from category where name = ?s", $cat);
                if(empty($db_check)){
                    $db->query("INSERT INTO category SET name = ?s", $cat);
                   // $db_check = $db->getRow("select id from category where name = ?s", $cat);
                }
                $u['category'] = $cat;
                $u['name_prod'] = $subcat;
                $db->query("INSERT INTO visitors SET ?u", $u);
            }

            if(!empty($subcat)){
                /*Выборка товаров, их категория и имя*/
                $db_check = $db->getRow("select id from category where name = ?s", $cat);
                $db->query("INSERT INTO goods SET name = ?s, category  = ?i", $subcat, $db_check['id']);
            }

    }
}
