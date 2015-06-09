<?php
namespace core;
use \Egolife_Session as Session;
use \Egolife_Redirect as Redirect;

class Controller{

  protected $_data = array();

  public function model($model){
    $model = '\\models' . '\\' . ucfirst($model);
    return new $model();
  }

  public function view($view, $data = array(), $header = 'inc/header', $footer = 'inc/footer'){
    if( is_array($data) ) extract($data);
    unset($data);

    if( !strrpos($header, '/')){
      $header = 'inc/' . $header;
    }
    require_once '../app/views/' . $header . '.view.php';
    require_once '../app/views/' . $view . '.view.php';
    require_once '../app/views/' . $footer . '.view.php';

    exit();
  }

  public function chunk($chunk, $data = array()){
    if( is_array($data) ) extract($data);
    unset($data);
    require_once '../app/views/' . $chunk . '.chunk.php';
  }
}