<?php
/**
* ---------------------------------------------------------------------------------------------------------------------------------------
* This file is for processing AJAX requests from index.php and ???
* ---------------------------------------------------------------------------------------------------------------------------------------
*/

require 'config.php';
require 'functions.php';

$conn = connect($db);
if (!conn) die('Problem connecting to the db.');

if($_POST['progress']){
	$id = htmlentities($_POST['progress']);

	if(move_progress('tasks', $conn, $id)) return;
	else echo "Изменения не внесены - повторите попытку!";
}

if($_POST['complete']){
	$id = htmlentities($_POST['complete']);
	if($_POST['date']) {
		$date = (integer)$_POST['date'];
	}
	if(complete_task('tasks', $conn, $id, $date)) return;
	else echo "Данное задание выполнено ранее!";
}

if($_POST['extraTask']){
	$id = (int)$_POST['extraTask'];
	$concat_id = ", ".$id;

	if( concat_today_tasks($conn, $concat_id, date("Ymd")) && add_new_today_task($conn, $id) ) return;
	else echo "Произошла непредвиденная ошибка!";
}

if($_POST['freeze_task']){
	$id = htmlentities($_POST['freeze_task']);

	if(freeze_task($conn, $id)) return;
	else echo "Произошла непредвиденная ошибка!";
}

if($_POST['unfreeze_task']){
	$id = htmlentities($_POST['unfreeze_task']);

	if(unfreeze_task($conn, $id)) return;
	else echo "Произошла непредвиденная ошибка!";
}

if($_POST['delete_task']){
	$id = htmlentities($_POST['delete_task']);

	if(delete_tasks($conn, $id)) return;
	else echo "Произошла непредвиденная ошибка!";
}

if($_POST['update_task']){
	$id = (int)$_POST['update_task'];
	$text = htmlentities_ru($_POST['text']);

	if(update_tasks($conn, $id, $text)){
		return;
	}
	else echo "Произошла непредвиденная ошибка!";
}