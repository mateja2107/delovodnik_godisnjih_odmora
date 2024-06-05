<?php
class User {
  private $conn;
  public $data = [];


  public function  __construct() {
    $this->conn = new Connection(CONN);
  }

 
  public function login($data) {
    $remember = false;
    if(array_key_exists('remember', $data)) {
      $remember = true;
      unset($data['remember']);
    }

    $sql = "SELECT * FROM users WHERE username = :username;";

    $user = Connection::getData($sql, ["username" => $data['username']]);
    if($user) {
      $user = $user[0];

      if(password_verify($data['password'], $user['password'])) {
        // if login is successfull
        $_SESSION['token'] = $user['token'];
        // $_SESSION['username'] = $user['username'];
        // $_SESSION['e_code'] = $user['e_code'];
        // $_SESSION['status'] = $user['status'];

        if($remember) {
          setcookie("token", $user['token'], time() + 3600 * 24, '/');
          // setcookie("id", $user['id'], time() + 3600 * 24, '/');
          // setcookie("username", $user['username'], time() + 3600 * 24, '/');
          // setcookie("e_code", $user['e_code'], time() + 3600 * 24, '/');
          // setcookie("status", $user['status'], time() + 3600 * 24, '/');
        }

        return ["success" => true];
      } else return ["errors" => ['Korisnicko ime ili lozinka nisu ispravni.']];
    } else return ["errors" => ['Korisnicko ime ili lozinka nisu ispravni.']];
  }

  public function register($data) {
    $this->data = $data;

    $this->data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
    $this->data['token'] = generateRandomString();

    $string = "";
    foreach($this->data as $key => $value) {
      $string .= "{$key} = :{$key}, ";
    }

    $string = rtrim($string, ', ');

    $sql = "INSERT INTO users SET {$string};";

    $res = $this->conn->insert($sql, $this->data);

    if($res == 1) {
      return ["success" => true];
    } else return $res;
  }

  public static function getUser($token) {
    $sql = "SELECT * FROM users WHERE token = :token";

    $user = Connection::getData($sql, ["token" => $token]);

    if($user) {
      return $user[0];
    } else return false;
  }

  public function editUser($id, $data) {
    $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

    $string = "";
    foreach($data as $key => $value) {
      $string .= "{$key} = :{$key}, ";
    }

    $string = rtrim($string, ', ');

    $sql = "UPDATE users SET {$string} WHERE id = :id";
    
    $res = $this->conn->update($sql, $id, $data);

    if($res == 1) {
      return ["success" => true];
    } else return $res;
  }
}