<?php
require_once __DIR__. '/vendor/autoload.php';

define('__DIR_ROOT__', __DIR__);

if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
    $local = 'https://' . $_SERVER['HTTP_HOST'];
}else{
    $local = 'http://' . $_SERVER['HTTP_HOST'];
}
$documentRoot = strtolower(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']));
$currentAddress = strtolower(str_replace('\\', '/', __DIR_ROOT__));
$folder = str_replace($documentRoot, '', $currentAddress);
$folderName = trim($folder, '/');
$local = $local.'/'.$folderName;
define('__WEB_ROOT__', $local);
require_once "./core/routes.php";
require_once "./Route.php";
require_once "./core/App.php";
require_once "./core/Database.php";
require_once "./core/BaseController.php";
require_once "./core/BaseModel.php";
?>