<?php
session_start();

define("DS", DIRECTORY_SEPARATOR);
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"]);
define("ROOT", "http://".$_SERVER["HTTP_HOST"]);
define("CSS", ROOT . '/css/');
define("IMG", ROOT . '/img/');
define("JS", ROOT . '/js/');
define("APP_PATH", realpath(dirname(__FILE__) . DS . "..". DS . "app" ));
define("CLASS_PATH", APP_PATH . DS . 'classes');
define("SOFT", "Time ver. 0.0.1");

require_once '/vendor/autoload.php';
require_once 'functions.php';

$localMysqlConf = array(
  'host' => '127.0.0.1',
  'username' => 'root',
  'password' => '',
  'db' => 'time'
);

if(strstr($_SERVER['DOCUMENT_ROOT'], "Z:")) $mysqlConfArray = $localMysqlConf;
  else $mysqlConfArray = $serverMysqlConf;

$GLOBALS['config'] = array(
  'mysql' => $mysqlConfArray,
  'pdo_mode' => PDO::ERRMODE_EXCEPTION, //EXCEPTION //SILENT //WARNING
  'remember' => array(
    'cookie_name' => 'hash',
    'cookie_expire' => 604800
    ),
  'session' => array(
    'session_name' => 'user',
    'token_name' => 'token'
    ) 
  );
