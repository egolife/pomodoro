<?php

namespace Models;

class FileTasksList implements TasksListGateway {
  private $fileID;

  function __construct() {
    $this->fileID = uniqid();
  }

  public function persist(TasksList $tasksList){
    file_put_contents($this->fileID, serialize($tasksList));
  }
  public function retrieve($id) {
    return unserialize(file_get_contents($id));
  }
  public function getLastPersistId() {
    return $this->fileID;
  }
}