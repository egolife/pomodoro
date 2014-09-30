<?php 

require 'blog.php';



$posts = get('posts', $conn);


$data = array();
$data['posts'] = $posts;


view('index', $data);



// $view_path = "index.tmpl.php";
// include 'views/layout.php';