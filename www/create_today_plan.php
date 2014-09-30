<?php 

require 'config.php';
require 'functions.php';

$tasks = array();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
	// var_dump($_POST);
	foreach ($_POST as $key => $value) {
		$tasks[] = (int)htmlspecialchars($value);
	}

	$ids = implode(", ", $tasks);

	$conn = connect($db);
	if (!conn) die('Problem connecting to the db.');

	try{
		query("insert into days (day, tasks) values (:today, :ids)", 
				array('today' => date("Ymd"), 'ids' => $ids), 
				$conn);
		echo "План на сегодня успешно создан";
	} catch(Exception $e){
		echo "Произошла ошибка - план на сегодня создан ранее";
	}
}

 ?>