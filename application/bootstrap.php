<?php
/**
 * Created by PhpStorm.
 * User: ukito
 * Date: 2016/02/27
 * Time: 12:34
 */

require ("core/Classloader.php");
var_dump(__DIR__);

$loader = new ClassLoader();


//オートロードの対象のディレクトリを増やす場合、下記を追加
//$loader->registerDir("ディレクトリ名");
$loader->registerDir(__DIR__ . "/cores");
$loader->registerDir(__DIR__ . "/models");


//オートロードを設定
$loader->register();