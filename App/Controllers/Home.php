<?php

namespace Controllers;
use \Egolife_Redirect as Redirect;
use \Egolife_Input as Input;
use \Egolife_Validate as Validate;
use \Egolife_Session as Session;
use \models\DB as DB;
use \Egolife_Email as Email;

class Home extends \Core\Controller{

  public function index() {
    $this->view('tasks', []);
  }



}