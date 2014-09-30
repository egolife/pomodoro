<?php 

require 'blog.php';

$post = get_by_id((int)$_GET['id'], $conn);

$data = array();
$data['post'] = $post;

if ($post){
	$post = $post[0];

	view('single', $data);

} else{
	header('location:/blog');
}






