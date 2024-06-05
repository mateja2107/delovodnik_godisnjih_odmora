<?php
session_start();

const CONN = [
  "db_name" => "bp_go",
  "host" => "localhost",
  "username" => "root",
  "password" => ""
];

require_once 'functions.php';
require_once 'classes/Connection.php';
require_once 'classes/User.php';
require_once 'classes/Rescript.php';

require_once 'router.php';

// $conn = [
//   "db_name" => "spa",
//   "host" => "localhost",
//   "username" => "root",
//   "password" => ""
// ];

$db = new Connection(CONN);

// public function login($data) {
//   $data['password'] = $data['login_password'];
//   unset($data['login_password']);

//   $remember = false;
//   if(array_key_exists('remember', $data)) {
//     $remember = true;
//     unset($data['remember']);
//   }

//   if(strpos($data['username_email'], '@') !== false && strpos($data['username_email'], '.') !== false) {
//     $data['email'] = $data['username_email'];
//     unset($data['username_email']);

//     $sql = "SELECT * FROM users WHERE email = :email AND password = :password";

//   } else {
//     $data['username'] = $data['username_email'];
//     unset($data['username_email']);

//     $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
//   } 

//   $user = Connection::getData($sql, $data)[0];

//   if($user) {
//     if($user['activated'] != 1) {
//       return ["errors" => ['Account is not verified.']];
//       die();
//     } 

//     // if login is successfull
//     $_SESSION['id'] = $user['verified'];
//     $_SESSION['user_id'] = $user['id'];
//     $_SESSION['username'] = $user['username'];
//     $_SESSION['email'] = $user['email'];

//     if($remember) {
//       setcookie("id", $user['verified'], time() + 3600 * 24, '/');
//       setcookie("user_id", $user['id'], time() + 3600 * 24, '/');
//       setcookie("username", $user['username'], time() + 3600 * 24, '/');
//       setcookie("email", $user['email'], time() + 3600 * 24, '/');
//     }

//     return ["success" => true];

//   } else return ["errors" => ['Invalid username/email or password.']];
  
// }