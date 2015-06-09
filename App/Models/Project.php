<?php

namespace Models;

class Project implements ProjectInterface {
  private $tasks;

  public function getTasks() {
    return $this->tasks;
  }
}