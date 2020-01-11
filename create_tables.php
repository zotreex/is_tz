<?php
include "config.php";
include "sqlsafe.php";
$db = new SafeMySQL($opts);

$db->query("CREATE TABLE `goods_in_carts` (
  `cart_id` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

$db->query("CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


$db->query("CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user` text NULL,
  `date_open` datetime NOT NULL,
  `date_close` datetime NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

$db->query("CREATE TABLE `products` (
  `id` int(11) DEFAULT NULL,
  `name` text NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

$db->query("CREATE TABLE `visitors` (
  `ip` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `category` text NOT NULL,
  `name_prod` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
