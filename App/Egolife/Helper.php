<?php
class Helper {
  public static function dd($val, $label = "End of output"){
    echo "<pre>";
    var_dump($val);
    echo "</pre>";

    die($label);
  }

  public static function htmlentities_ru($str){
    return htmlentities($str, ENT_QUOTES, 'UTF-8');
  }

  public static function convert1251(Array $arr){
    for ($i = 0; $i < count($arr); $i++) { 
      $arr[$i] = iconv("UTF-8", "Windows-1251", $arr[$i]);
    }
    return $arr;
  }

  public static function sanitize($array){
    foreach ($array as $item) {
      $item = trim($item);
    }
    return $array;
  }

  public static function filter_array($arr, $str){
    $new_array = array();
    foreach ($arr as $key => $value) {
      if(strstr($key, $str) && $value){
        array_push($new_array, $value);
      }
    }

    return $new_array;
  }

  public static function zero_only_array($arr){
    $not_zero_values = false;
    foreach ($arr as $value) {
      if($value) {
        $not_zero_values = true;
        break;
      }
    }

    if($not_zero_values) return false;
    return true;
  }
}