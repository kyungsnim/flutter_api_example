<?php

class MyDB
{
  public mysqli $connection;

  public function __construct(string $host, string $dbname, string $username, string $passwd, int $port = 0) {
    try {
      if (!$port) $port = ini_get("mysqli.default_port");
      $this->connection = new mysqli($host, $username, $passwd, $dbname, $port);
    } catch (Exception $e) {
      $this->handleError($e->getCode() . ': ' . $e->getMessage());
    }
  }

  private function handleError(string $msg, string $sql = '') {
    $error_message = '== Mysql error: ' . $msg . $sql;
    debug_log($error_message);
    throw new RuntimeException($error_message);
  }

  /**
   *  @param string $table : 레코드 생성할 테이블
   *  @param array $record : 레코드의 필드(키)와 값을 연관 배열로 입력 받는다.
   */
  public function insert(string $table, array $record) {
    // 입력 받은 배열에서 필드/값을 분리시켜 각각 $fields와 $values로 저장
    $fields = [];
    $values = [];
    foreach ($record as $f => $v) {
      $fields = $f;
      $values[] = $v;
    }

    // statement 준비
    $stmt = $this->connection->stmt_init();

    // 입력 받은 테이블과 레코드 정보를 바탕으로 SQL문 만들기
    $sql = "INSERT INTO $table (" . implode(',', $fields) . ") VALUES (" . implode(",", array_fill(0, count($values), '?')) . ")";
    $re = $stmt->prepare($sql);
    if(!$re) {
      $this->handleError($this->connection->error, $sql);
    }

    // 저장할 값의 타입 계산
    $types = $this->types($values);

    // SQL 문장을 바탕으로 값의 타입과 값을 바인드
    $stmt->bind_param($types, ...$values);

    // 쿼리
    $re = $stmt->execute();
    if(!$re) {
      $this->handleError($this->connection->error, $sql);
    }
  }

  public function delete(string $table, array $conds): bool {
    try {
      $stmt = $this->connection->stmt_init();

      $sql = "DELETE FROM $table WHERE age = ?";
      $stmt->prepare($sql);
      $types = $this->types($conds);
      $stmt->bind_param($types, $conds['age']);

      return $stmt->execute();
    } catch (mysqli_sql_exception $e) {
      $this->handleError($e->__toString(), $sql);
      return false;
    }
  }

  public function update(string $table, array $conds): bool {
    try {
      $stmt = $this->connection->stmt_init();

      $sql = "UPDATE $table SET name = ? WHERE ";
      $stmt->prepare($sql);
      $types = $this->types($conds);
      $stmt->bind_param($types, $conds['name']);

      return $stmt->execute();
    } catch (mysqli_sql_exceptin $e) {
      $this->handleError($e->__toString(), $sql);
      return false;
    }
  }

  public function rows(string $table/*, array $conds */) {
    try {
      $stmt = $this->connection->stmt_init();

      $sql = "SELECT * FROM $table";
      $stmt->prepare($sql);
      // $types = $this->types($conds);
      // return $stmt->execute();
    } catch (mysqli_sql_exceptin $e) {
      $this->handleError($e->__toString(), $sql);
      return false;
    }
  }

  private function type(mixed $val): string {
    if($val == '' || is_string($val)) return 's';
    if(is_float($val)) return 'd';
    if(is_int($val)) return 'i';
    return 'b';
  }

  private function types(array $values): string {
    $type = '';
    foreach($values as $val) {
      $type .= $this->type($val);
    }

    return $type;
  }
}

$mysqli = new MyDB("mariadb", "mydb", "myuser", "mypath12345");

function db(): MyDB {
  global $mysqli;
  return $mysqli;
}

// $db_name = "mydb";
// $db_server = "mariadb"; // mariadb로 해야 하나?
// $db_user = "myuser";
// $db_pass = "mypath12345";
// 
// $db = new PDO("mysql:host={$db_server};dbname={$db_name};charset=utf8", $db_user, $db_pass);
// $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
// $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 
// $db = new SQLite3($db_name);
// 
// $db = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
// 
// // Check connection
// if (mysqli_connect_errno())
//   {
//   echo "Failed to connect to MySQL: " . mysqli_connect_error();
//   }