<?php
class Email {
  public static function send($adress, $message, $extra_address = null){

    if(!$adress){
      return;
    }

    $receivers = $adress;
    if($extra_address){
      $receivers .= ", " . $extra_address;
    }
    $subject = "=?utf-8?B?". base64_encode("Событие в системе Colibri:"). "?="; 

    $headers = '';
    $headers .= "Mime-Version: 1.0\r\n";
    $headers .= "Content-type: text/plain"."; charset=UTF-8\r\n";

    return mail($receivers, $subject, $message, $headers);
  }
}