<?php
namespace models;
use \PDO;
class DB implements DBInterface{
  
  private static $_instance = null; //underscore is a notation to show a private method
  
  private $_pdo,        //store connection
      $_query,      //store the last executed query
      $_error = false,  //errors if some
      $_results,      //last result set
      $_count = 0;    //count of results

  private function __construct(){
    try{
      $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
      $this->_pdo->exec('SET CHARACTER SET utf8');
      $this->_pdo->setAttribute( PDO::ATTR_ERRMODE, Config::get('pdo_mode') );
    } catch(PDOException $e){
      die($e->getMessage());
    }
  }

  /**
   * Реализует паттерн синглтон,
   * возвращает объект класса или создает, если еще нет
   * @return DB (весь объект)
   */
  public static function getInstance(){
    if(!isset(self::$_instance)){
      self::$_instance = new DB();
    }
    return self::$_instance;
  }

  /**
   * Базовая функция для запросов к БД,
   * Возвращаемые значения пишутся в $this->_results,
   * Количество затронутых строк в $this->_count,
   * @param  string $sql    Запрос mysql, с шаблонами '?' для подстановки значений
   * @param  array  $params Массив значений подстановки (важен порядок следования)
   * @param  const $mode    Константа PDO (FETCH_ALL, FETCH_OBJ, FETCH_ASSOC, FETCH_ARRAY)
   * @return DB (весь объект)
   */
  public function query($sql, $params = array(), $mode = PDO::FETCH_OBJ){

    $this->_error = false;
    if($this->_query = $this->_pdo->prepare($sql)){
      $x = 1;
      if(count($params)){
        foreach ($params as $param) {
          $this->_query->bindValue($x, $param);
          $x++;
        }
      }
      if($this->_query->execute()){
        $this->_count = $this->_query->rowCount();
        if($this->_query->columnCount()){
          $this->_results = $this->_query->fetchAll($mode);
        }
      } else{
        $this->_error = true;
      }
    }
    return $this;
  }

  /**
   * Функция обертка для более специфичных методов класса DB
   * @param  string $action (SELECT * | DELETE | etc)
   * @param  string $table  table name
   * @param  array  $where  Условия для sql оператора WHERE, строго 3 элемента
   * @return DB (весь объект)
   */
  public function action($action, $table, $where = array()){
    if(count($where) === 3){ //field, operator, value
      $operators = array('=', '>', '<', '>=', '<=', '<>');

      $field    = $where[0];
      $operator   = $where[1];
      $value    = $where[2];

      if(in_array($operator, $operators)){
        $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
        if(!$this->query($sql, array($value))->error()) {
          return $this;
        }
      }
    }
    return false;
  }

  /**
   * Получаем записи из БД
   * @param  string $table Название таблицы
   * @param  array $where Условия для sql оператора WHERE, строго 3 элемента
   * @return DB (весь объект)
   */
  public function get($table, $where){
    return $this->action('SELECT *', $table, $where);
  }

  /**
   * Удаляем записи из БД
   * @param  string $table Название таблицы
   * @param  array $where Условия для sql оператора WHERE, строго 3 элемента
   * @return DB (весь объект)
   */
  public function delete($table, $where){
    return $this->action('DELETE', $table, $where);
  }

  /**
   * Добавление записей в БД
   * @param  string $table Название таблицы
   * @param  array  $fields Пары "столбец" => "значение"
   * @return bool   true, в случае успешного выполнения запроса, иначе - false
   */
  public function insert($table, $fields = array()){
    if(count($fields)){
      $keys = array_keys($fields);
      $values = "";
      $x = 1;

      foreach ($fields as $field) {
        $values .= "?";
        if($x < count($fields)){
          $values .= ", ";
        }
        $x++;
      }
      $sql = "INSERT INTO $table (`"  . implode('`, `', $keys) .  "`) VALUES ({$values})";
      if(!$this->query($sql, $fields)->error()){
        return true;
      }
    }
    return false;
  }

  /**
   * Изменение записей в БД
   * @param  string $table  название таблицы
   * @param  int $id     номер записи
   * @param  array $fields Пары "столбец" => "значение"
   * @return bool   true, в случае успешного выполнения запроса, иначе - false
   */
  public function update($table, $id, $fields){
    $set = '';
    $x = 1;

    foreach ($fields as $name => $value) {
      $set .= "{$name} = ?";
      if($x < count($fields)){
        $set .= ", ";
      }
      $x++;
    }
    $sql = "UPDATE `{$table}` SET {$set} WHERE id = {$id}";
    if(!$this->query($sql, $fields)->error()){
      return true;
    }
    return false;
  }

  /**
   * Возвращает переменную $this->_results
   * @return array Массив результатов последнего запроса к БД
   */
  public function results(){
    return $this->_results;
  }

  /**
   * Возвращает первый элемент коллекции результатов
   * @return mix Результат последнего запроса к БД (тип зависит от параметров $this->query)
   */
  public function first(){
    $results = $this->results();
    return $results[0];
  }

  /**
   * Индикатор наличия ошибок в последнем запросе к БД
   * @return bool true при наличии ошибок
   */
  public function error(){
    return $this->_error;
  }
  /**
   * Возвращает количество строк, затронутых последним запросом 
   * @return [type] [description]
   */
  public function count(){
    return $this->_count;
  }

  /**
   * Возвращает id последней затронутой строки БД
   * @return int id затронутой строки
   */
  public function lastId(){
    return $this->_pdo->lastInsertId();
  }

  /**
   * Возвращает тело последнего запроса к БД
   * @return string Тело запроса (для отладки)
   */
  public function get_query(){
    return $this->_query;
  }

  /**
   * Запускает транзакцию
   * @return bool true|false
   */
	public function beginTransaction(){
		return $this->_pdo->beginTransaction();
	}

	/**
	 * Подтверждает транзакцию
	 * @return bool true|false
	 */
	public function commit(){
		return $this->_pdo->commit();
	}

	/**
	 * Откатывает транзакцию
	 * @return bool true|false
	 */
	public function rollBack(){
		return $this->_pdo->rollBack();
	}
}