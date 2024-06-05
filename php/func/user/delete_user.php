<?php
if($_SERVER['REQUEST_METHOD'] == "POST" && $_GET['action'] == "delete") {
  $session = loadPage();

  if($session['status'] == 'admin') {
    $data = json_decode(file_get_contents("php://input"), true);

    $sql = "DELETE FROM users WHERE id = :id";
    
    $user = new User();
    $user = $user->getUser($_SESSION['token']);

    if($user['id'] != $data['id']) {
      $deleted = Connection::delete($sql, $data['id']);
    } else {
      $deleted = ["errors" => "Ne mozete obrisati svoj profil."];
    }

    echo json_encode($deleted);
  } else header("Location: /");
}