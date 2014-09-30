<?php 

function connect($db){
	try{
		$conn = new PDO('mysql:host=localhost;dbname=' .$db['database'],
			$db['username'],
			$db['password']
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

	return ($stmt->rowCount() > 0) ? $stmt : false;

}

function move_progress($table, $conn, $id){

	$query = query('update tasks set progress = if(progress, progress + 1, 1) 
		where id = :id',
				array('id' => $id),
				$conn);

	if ($query) return true;

	return false;

}

function complete_task($table, $conn, $id){

	$query = query('update tasks set complete_date = NOW() 
		where complete_date is NULL and id = :id',
				array('id' => $id),
				$conn);

	if ($query) return true;

	return false;
}

function freeze_task($conn, $id){

	$query = query('update tasks set is_freezed = 1 where id = :id limit 1',
				array('id' => $id),
				$conn);

	if ($query) return true;

	return false;

}

function unfreeze_task($conn, $id){

	$query = query('update tasks set is_freezed = 0 where id = :id limit 1',
				array('id' => $id),
				$conn);

	if ($query) return true;

	return false;

}

function concat_today_tasks($conn, $id, $date){

	$query = query('update days set tasks = concat(tasks, :id) 
		where day=:date',
				array('id' => $id,
					'date' => $date),
				$conn);

	if ($query) return true;

	return false;

}


function get($tableName, $conn, $limit = 100){
	try{
		$result = $conn->query("SELECT * FROM $tableName inner join activity_type on activity_type.id = tasks.type_id LIMIT $limit");
		// $result = $conn->query("select task, pomodoros, set_date, name from tasks inner join activity_type on activity_type.id = tasks.type_id;");

		return($result->rowCount() > 0) ? $result : false;
	} catch(Exception $e){
		return false;
	}
}

function get_by_date($tableName, $conn, $date){

	try{
		$result = $conn->query("SELECT * FROM $tableName where day=$date limit 1");

		return($result->rowCount() > 0) ? $result : false;
	} catch(Exception $e){
		return false;
	}
}

function get_uncomplete($tableName1, $tableName2, $conn, $null_column, $freezed){

	$query  = "SELECT name, $tableName1.id, task, pomodoros, complete_date, is_freezed ";
	$query .= "FROM $tableName1 INNER JOIN $tableName2 on $tableName2.id = $tableName1.type_id ";
	$query .= "WHERE $null_column IS NULL ";
	if(!$freezed) $query .= " AND `is_freezed` <> 1 ";
	$query .= "ORDER BY $tableName1.id DESC";

	try{
		$result = $conn->query($query);
		return($result->rowCount() > 0) ? $result : false;
	} catch(Exception $e){
		return false;
	}
}

function get_id($task, $conn){
	$query = query('select id from  tasks where task=:task limit 1',
				array('task' => $task),
				$conn);

	if ($query) return $query->fetchAll();
}

function get_by_id($id, $conn){
	$query = query('select * from posts where id=:id limit 1',
				array('id' => $_GET['id']),
				$conn);

	if ($query) return $query->fetchAll();
}

function get_rows_by_id($id, $conn){

	$placeholders = implode(",", array_fill(0, count($id), '?'));

	$query = query("select tasks.id, task, complete_date, pomodoros, progress, name from tasks 
		inner join activity_type on activity_type.id = type_id 
		where tasks.id IN ($placeholders) ORDER BY tasks.id",
				$id, // I must remember what this array cant be a hash
				$conn);
	if ($query) return $query->fetchAll();
}

function view($path, $data = null){

	if ($data){
		extract($data);
	}

	include "views/{$path}.view.php";
}


function dump_and_die($arr){

	echo "<pre>";
	var_dump($arr);
	echo "</pre>";

	die();
}


function dd($obj){
	echo "<pre>";
	var_dump($obj);
	echo "</pre>";
	die("END OF DIE_AND_DUMP");
}

function htmlentities_ru($str){
	return htmlentities($str, ENT_QUOTES, 'UTF-8');
}

function date_ru($datetime){
	return date_format(date_create($datetime), 'd-m-Y H:i:s');
}


/**
* ---------------------------------------------------------------------------------------------------------------------------------------
* Построение запроса с двойным join (вложенность)
* ---------------------------------------------------------------------------------------------------------------------------------------
*/
// SELECT name, task, pomodoros FROM `tasks_06-06-14` 
// inner join `tasks` on `tasks`.id = `tasks_06-06-14`.task_id 
// inner join `activity_type` on type_id = `activity_type`.id;


//<td><?php echo $task['complete_date'] !== NULL 
//? $task['complete_date'] 
//: "uncomplete"; 
//</td>

 ?>