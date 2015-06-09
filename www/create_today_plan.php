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

		$current_date_created = query(
			"SELECT * FROM days WHERE day = :today LIMIT 1",
			array('today' => date('Ymd')),
			$conn
		);

		if( $current_date_created ) { throw new Exception('План на сегодня создан ранее!'); }

		#Этот запрос станет нужен, когда в таблице days будут храниться только даты
		// query("INSERT INTO days (day) VALUES (:today)", array('today' => date('Ymd')));
		
		#Этот запрос нужен для поддержки обратной совместимости с версией от июля2014
		query("insert into days (day, tasks) values (:today, :ids)", 
				array('today' => date("Ymd"), 'ids' => $ids), 
				$conn);

		$res = $conn->lastInsertId();

		$day_task_placeholder_string = '';
		$day_task_values = array('today' => $res);

		for($i = 1; $i <= count($tasks); $i++) {
			$day_task_placeholder_string .= "(:today, :task{$i})";
			if($i < count($tasks)) $day_task_placeholder_string .= ", ";

			$day_task_values["task" . $i] = $tasks[$i - 1];
		}

		$rest = query(
			"INSERT INTO days_have_tasks (days_id, tasks_id) VALUES {$day_task_placeholder_string}",
			$day_task_values,
			$conn
		);

		echo "План на сегодня успешно создан";

	} catch(Exception $e){
		echo $e->getMessage();
	}
}