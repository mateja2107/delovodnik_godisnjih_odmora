<?php
if($_SERVER['REQUEST_METHOD'] == "POST" && $_GET['action'] == 'get_all_rescripts') {
  $session = loadPage();

  $data = json_decode(file_get_contents("php://input"), true);
  $date = $data['date'];

  validate_date($date);
  
  $sql = "SELECT * FROM rescripts WHERE from_date >= '{$date}-01-01' AND from_date <= '{$date}-12-31';";

  $rescripts = Connection::getData($sql);

  echo json_encode($rescripts);

  die();
}

if($_SERVER['REQUEST_METHOD'] == "POST" && $_GET['action'] == 'get_one_rescript') {
  $session = loadPage();

  $data = json_decode(file_get_contents("php://input"), true);
  
  $sql = "SELECT * FROM rescripts WHERE id = :id;";

  $rescript = Connection::getData($sql, $data)[0];

  if($session['id'] == $rescript['author'] || $session['status'] == 'admin') {
    echo json_encode($rescript);
    
  } else echo json_encode(["errors" => "Mozete da izmenite samo resenje koje ste Vi uneli."]);

  die();
}

if($_SERVER['REQUEST_METHOD'] == "POST" && $_GET['action'] == 'search_by_e_code') {
  $session = loadPage();

  $data = json_decode(file_get_contents("php://input"), true);

  $sql = "SELECT * FROM rescripts WHERE e_code = :e_code;";

  $rescripts = Connection::getData($sql, $data);

  echo json_encode($rescripts);

  die();
}

if($_SERVER['REQUEST_METHOD'] == "POST" && $_GET['action'] == 'get_old_rescripts') {
  $session = loadPage();

  if($session['status'] == 'admin') {
    $data = json_decode(file_get_contents("php://input"), true);

    $year = $data['year'];
    validate_date($year);

    $sql = "SELECT * FROM rescripts WHERE from_date >= '{$year}-01-01' AND from_date <= '{$year}-12-31';";

    $rescripts = Connection::getData($sql);

    $res = [];
    foreach($rescripts as $rescript) {

      $sql = "SELECT * FROM old_rescripts WHERE old_id = {$rescript['id']}";
      $old_rescripts = Connection::getData($sql);

      $user = Connection::getData("SELECT username, e_code FROM users WHERE id = {$rescript['author']};")[0];
      $rescript['author'] = "{$user['username']} - {$user['e_code']}";
      
      if(count($old_rescripts) > 0) {
        $res[] = [
          "new" => $rescript,
          "old" => $old_rescripts
        ];
      }
    }

    echo json_encode($res);
    die();
  }
}