<?php 

require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$name = trim($_POST['name']);
	$email = trim($_POST['email']);

	if ( empty($name) || empty($email) || !valid_email($email)){
		$status = "please Provide a valid name and email";
	}
	else{
		add_registered_user($name, $email);
		$status = 'Thank you for the registering, your information was added to the subscribe list';
	}
}
require('index.tmpl.php');
 ?>