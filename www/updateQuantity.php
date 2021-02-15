<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../classes/Products.php');
$product=new Products(new PDO('mysql:dbname=inventory;host=127.0.0.1','dev','password'));

$product->addQuantity($_REQUEST['id'],$_REQUEST['quantity']);
header("Location: /?alert=Quantity%20Updated"); /* Redirect browser */

