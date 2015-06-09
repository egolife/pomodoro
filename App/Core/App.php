<?php

namespace core;
use models\Helper;
/**
 * Url Parsing
 * Routing
 * Loading controller
 */
class App{
  protected $controller = 'Home';
  protected $method = 'index';
  protected $params = array();

  public function __construct(){
    $url = $this->parseUrl($_GET['url']);

    if(file_exists('../app/controllers/' . ucfirst($url[0]) . '.php')){
      $this->controller = ucfirst($url[0]);
      unset($url[0]);
    }

    $controller = '\Controllers' . '\\' . $this->controller;
    $this->controller = new $controller;

    if(isset($url[1])){
      if(method_exists($this->controller, $url[1])){
        $this->method = $url[1];
        unset($url[1]);
      }
    }

    $this->params = $url ? array_values($url) : array();
    call_user_func_array( array($this->controller, $this->method), $this->params );
  }

  protected function parseUrl($url = null){
    if(isset( $url )) {
      return explode('/', filter_var( rtrim($url, '/'), FILTER_SANITIZE_URL));
    }
  }
}