<?php 

$config = array(
	'username' => 'root',
	'password' => '',
	'database' => 'blog'
);


function connect($config){
	try{
		$conn = new PDO('mysql:host=localhost;dbname=' .$config['database'],
			$config['username'],
			$config['password']
		);

		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $conn;
	}catch(Excepiton $e){
		return false;
	}
}

function query($query, $bindings, $conn){
	$stmt = $conn->prepare($query);
	$stmt->execute($bindings);

	$results = $stmt->fetchAll();

	return $results ? $results : false;
}

function get($tableName, $conn, $limit = 10){
	try{
		$result = $conn->query("SELECT * FROM $tableName LIMIT $limit");

		return($result->rowCount() > 0) ? $result : false;
	} catch(Exception $e){
		return false;
	}
}

function get_by_id($id, $conn){
	return query('select * from posts where id=:id limit 1',
				array('id' => $_GET['id']),
				$conn);
}

function view($path, $data = null){

	if ($data){
		extract($data);
	}

	include "views/{$path}.tmpl.php";
}
