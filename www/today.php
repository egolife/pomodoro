<?php 

require 'config.php';
require 'functions.php';

$conn = connect($db);
If (!conn) die('Problem connecting to the db.');


$tasks = get('tasks', $conn);

$data = array();

$data['tasks'] = $tasks;


view('today', $data);

 ?>