<?php

namespace Models;

class ProjectProxy implements ProjectInterface{

  private $project;

  public function getTasks() {

    if(is_null($this->$project))
      $this->project = new Project();
    return $this->project->getTasks();
  }
}