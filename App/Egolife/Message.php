<?php
class Message {
  public static function context($string) {
    if(strpos($string, 'error:') !== false) return 'danger';
    if(strpos($string, 'success:') !== false) return 'success';
    if(strpos($string, 'warning:') !== false) return 'warning';
    if(strpos($string, 'info:') !== false) return 'info';

    return 'info';
  }
  public static function message($string){
    return str_replace(array('error:', 'success:', 'warning:', 'info:'), array('<strong>Произошла ошибка!</strong> ', '<strong>Все ок!</strong> ', '<strong>Внимание!</strong> ', ''), $string);
  }
}