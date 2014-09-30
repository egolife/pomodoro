<?php 

require 'config.php';
require 'functions.php';

$conn = connect($db);
if (!conn) die('Problem connecting to the db.');

if($_GET["archive"]){
	$archive = 1;
} else{
	$archive = 0;
}
$tasks = get_uncomplete('tasks', 'activity_type', $conn, 'complete_date', $archive);

$data = array();

$data['tasks'] = $tasks;
$data['archive'] = $archive;
view('planning', $data);

 ?>