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

	if(complete_task('tasks', $conn, $id)) return;
	else echo "Данное задание выполнено ранее!";
}

if($_POST['extraTask']){
	$id = htmlentities($_POST['extraTask']);
	$id = ", ".$id;

	if(concat_today_tasks($conn, $id, date("Ymd"))) return;
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