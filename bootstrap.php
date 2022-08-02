<?php
require_once "vendor/autoload.php";
$connectionParams = [
    'url' => 'mysql://test:test@localhost/iamdb',
];
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
if (!function_exists("dd"))
{
    function dd($obj){
        var_dump($obj);
        die();
    }
}

if (!function_exists('d')){
    function d($str){echo $str . PHP_EOL; exit;}
}