<?php

namespace Models;

class Task {

  private $id,
          $title,
          $tomatoes;
  public function __construct(Array $item = [], $id = null) {

    if(count($item)){
      $this->title = $item['title'];
      $this->tomatoes = $item['tomatoes'];
    }

    if( isset($id) ){
      $this->db = DB::getInstance();
    } else {

    }
  }

  public function getTitle(){
    return $this->title;
  }
  public function getTomatoes(){
    return $this->tomatoes;
  }
  public function __get($prop){
    return $this->$prop;
  }

}