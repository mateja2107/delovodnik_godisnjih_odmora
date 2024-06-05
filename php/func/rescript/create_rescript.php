<?php

if($_SERVER['REQUEST_METHOD'] == "POST" && $_GET['action'] == "create_new_rescript") {
  $session = loadPage();

  $data = json_decode(file_get_contents("php://input"), true);

  validate_rescript_data($data);

  // $data['days_number'] = calculateWorkDays($data['from_date'], $data['to_date']);
  $data['author'] = $session['id'];

  $rescript = new Rescript();

  echo json_encode($rescript->createNew($data, 'rescripts'));

  die();
} else header("Location: /");