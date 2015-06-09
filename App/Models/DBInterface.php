<?php
namespace models;

interface DBInterface{

  public static function getInstance();

  public function query($sql, $params = array(), $mode = PDO::FETCH_OBJ);
  public function action($action, $table, $where = array());
  public function get($table, $where);
  public function delete($table, $where);
  public function insert($table, $fields = array());
  public function update($table, $id, $fields);

  public function results();
  public function first();
  public function error();
  public function count();
  public function lastId();
  public function get_query();
}