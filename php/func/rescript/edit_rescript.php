<?php
if($_SERVER['REQUEST_METHOD'] == "POST" && $_GET['action'] == 'edit_one_rescript') {
  $session = loadPage();

  $data = json_decode(file_get_contents("php://input"), true);

  $id = $data['id'];
  $data = $data['data'];

  $sql = "SELECT * FROM rescripts WHERE id = :id;";

  $rescript = Connection::getData($sql, ['id' => $id])[0];

  if($rescript['author'] == $session['id'] || $session['status'] == 'admin') {
    if(isWithinLast24Hours($rescript['created_at']) || $session['status'] == 'admin') {
      $rescript['old_id'] = $rescript['id'];
      $rescript['author'] = "{$session['username']} - {$session['e_code']}";

      unset($rescript['id']);
      unset($rescript['edited_at']);
      unset($rescript['deleted']);

      $old_rescript = Connection::getData("SELECT * FROM old_rescripts WHERE old_id = {$rescript['old_id']};");
      if(count($old_rescript) != 0) {
        Connection::delete("DELETE FROM old_rescripts WHERE old_id = :id", $rescript['old_id']);
      }

      $old_rescript = new Rescript();
      $old_rescript->createNew($rescript, 'old_rescripts')['success'];

      validate_rescript_data($data);

      $res = new Rescript();

      echo json_encode($res->updateRescript($id, $data));
    } else echo json_encode(["errors" => ["Mozete da izmenite samo resenja koja su kreirana u prethodnih 24h."]]);
  
  } else echo json_encode(["errors" => ["Mozete da izmenite samo resenje koje ste Vi uneli."]]);

  die();
}