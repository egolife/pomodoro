<?php 

require 'config.php';
require 'functions.php';

$data = array();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

	$type_id = htmlentities($_POST['type']);
	$task = htmlspecialchars($_POST['activity']);
	$pomodoros = htmlentities($_POST['estimate']);


	$conn = connect($db);
	If (!conn) die('Problem connecting to the db.');

	query(
			"INSERT INTO tasks(type_id, task, pomodoros) VALUES(:type, :task, :pomodoros)",
			array('type' => $type_id, 'task' => $task, 'pomodoros' => $pomodoros),
			$conn
		);

	$id = $conn->lastInsertId();
	$data['inserted_row'] = get_by_id($id, $conn);
	$data['status'] = "Задача успешно добавлена в базу данных!";
	$data['id'] = $id;

	echo json_encode($data);
}

 ?>