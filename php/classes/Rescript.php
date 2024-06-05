<?php
class Rescript {
  private $conn;
  public $data = [];


  public function  __construct() {
    $this->conn = new Connection(CONN);
  }

  public function createNew($data, $table) {
    $string = "";

    foreach($data as $key => $value) {
      $string .= "{$key} = :{$key}, ";
    }
    $string = rtrim($string, ', ');

    $sql = "INSERT INTO {$table} SET {$string}";

    $res = $this->conn->insert($sql, $data);

    if($res) {
      return ["success" => true];
    } else return $res;
  }

  public function updateRescript($id, $data) {
    // $data['days_number'] = calculateWorkDays($data['from_date'], $data['to_date']);

    $string = "";

    foreach($data as $key => $value) {
      $string .= "{$key} = :{$key}, ";
    }
    $string = rtrim($string, ', ');

    $sql = "UPDATE rescripts SET {$string} WHERE id = :id;";

    $res = $this->conn->update($sql, $id, $data);

    if($res == 1) {
      return ["success" => true];
    } else return $res;
  }
}