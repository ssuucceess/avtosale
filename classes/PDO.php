﻿<?
//имя базы
$dbn = 'd6idli4g98j9lu';
//имя сервера
$dbh = 'ec2-54-247-71-245.eu-west-1.compute.amazonaws.com';
//порт
$dbr = '5432';
//имя пользователя
$dbu = 'qcayoyioybukio';
//пароль
$dbp = 'c1f2aaf5ba994380d562c9346a33c81b0775fd9d3f891f889acf09f1f0d2278c';

  ob_start();
  session_name('sid');
  @session_start();
  define ('DBHOST', "$dbh");
  define ('DBPORT', "$dbr");
  define ('DBNAME', "$dbn");
  define ('DBUSER', "$dbu");
  define ('DBPASS', "$dbp");
if (!class_exists('PDO'))
                   die('Fatal Error: Для работы нужна поддержка PDO');
class PDO_ extends PDO {
function __construct($dsn, $username, $password) {
parent :: __construct($dsn, $username, $password);
$this -> setAttribute(PDO :: ATTR_ERRMODE, PDO :: ERRMODE_EXCEPTION);
$this -> setAttribute(PDO :: ATTR_DEFAULT_FETCH_MODE, PDO :: FETCH_ASSOC);
}

function prepare($sql) {
$stmt = parent :: prepare($sql, array(
PDO :: ATTR_STATEMENT_CLASS => array('PDOStatement_')
));
return $stmt;
}
function query($sql, $params = array()) {
$stmt = $this -> prepare($sql);
$stmt -> execute($params);
return $stmt;
}
function querySingle($sql, $params = array()) {
$stmt = $this -> query($sql, $params);
$stmt -> execute($params);
return $stmt -> fetchColumn(0);
}
function queryFetch($sql, $params = array()) {
$stmt = $this -> query($sql, $params);
$stmt -> execute($params);
return $stmt -> fetch();
}
}
class PDOStatement_ extends PDOStatement {
function execute($params = array()) {
if (func_num_args() == 1) {
$params = func_get_arg(0);
} else {
$params = func_get_args();
}
if (!is_array($params)) {
$params = array($params);
}
parent :: execute($params);
return $this;
}

function fetchSingle() {
return $this -> fetchColumn(0);
}

function fetchAssoc() {
$this -> setFetchMode(PDO :: FETCH_NUM);
$data = array();
while ($row = $this -> fetch()) {
$data[$row[0]] = $row[1];
}
return $data;
}
}
class DB {
static $the;
public function __construct() {
try {
self :: $the = new PDO_('mysql:host=' . DBHOST . ';port=' . DBPORT . ';dbname=' . DBNAME, DBUSER, DBPASS);
self :: $the -> exec('SET CHARACTER SET utf8');
self :: $the -> exec('SET NAMES utf8');
}
catch (PDOException $e) {
die('Connection failed: ' . $e -> getMessage());
}
}
}
$array = explode(" ",microtime());
$gen = $array[1] + $array[0];
$db = new DB();
DB::$the->query("SET NAMES utf8");


?>
