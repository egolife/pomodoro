<?php

namespace Models;

class TasksHistory {
  private $gateway,
          $taskListIds = [];

  function __construct(TasksListGateway $gateway, $ids = []) {
    $this->gateway = $gateway;
    $this->taskListIds = $ids;
  }

  public function getAllLists()
  {
    $taskLists = [];

    foreach ($this->taskListIds as $id) {
      $taskLists[] = $this->gateway->retrieve($id);
    }

    return $taskLists;
  }
}