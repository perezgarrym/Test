<?php
require __DIR__ . "/inc/bootstrap.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

if ((isset($uri[1]) && $uri[1] != 'sale') || !isset($uri[2])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}
 
require PROJECT_ROOT_PATH . "/Controller/Api/PointOfSaleTerminal.php";
 
$terminal = new PointOfSaleTerminal();
$strMethodName = $uri[2];
$terminal->{$strMethodName}();
?>