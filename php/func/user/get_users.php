<?php
if($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['action'] == "get_all_users") {
  $session = loadPage();

  if($session['status'] == 'admin') {
    $sql = "SELECT * FROM users;";

    $users = Connection::getData($sql);

    echo json_encode($users);
  } else {
    header("Location: /");
  }
}

if($_SERVER['REQUEST_METHOD'] == "POST" && $_GET['action'] == "get_user") {
  $session = loadPage();

  if($session['status'] == 'admin') {
    $data = json_decode(file_get_contents("php://input"), true);

    $sql = "SELECT * FROM users WHERE id = :id";

    $user = Connection::getData($sql, $data);

    echo json_encode($user);
  } else {
    header("Location: /");
  }
}

if($_SERVER['REQUEST_METHOD'] == "POST" && $_GET['action'] == "get_username") {
  $session = loadPage();

  $data = json_decode(file_get_contents("php://input"), true);

  $sql = "SELECT username, e_code FROM users WHERE id = :id";

  $user = Connection::getData($sql, $data);

  echo json_encode($user);
}