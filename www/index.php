<?php 

require 'config.php';
require 'functions.php';

$data = array();

$conn = connect($db);
if (!conn) die('Problem connecting to the db.');

$data_for_today = get_by_date("days", $conn, date("Ymd"));

$data['today_tomatoes'] = get_today_tomatoes($conn);

if(!$data_for_today){
	header("Location: planning.php");
}

foreach ($data_for_today as $row) {
	$tasks = $row;
}

$id_of_today_tasks = explode(", ", $tasks["tasks"]);;

$today_tasks = get_rows_by_id($id_of_today_tasks, $conn);

$data['today_tasks'] = $today_tasks;
$data['total_estimated'] = get_total_estimate($today_tasks); 

view('index', $data);