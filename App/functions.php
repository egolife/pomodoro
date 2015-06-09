<?php 

function dd($val) {

  echo "<pre>";
  var_dump($val);
  echo "</pre>";
  die(__FILE__);
}