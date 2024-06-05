<?php

if($_SERVER['REQUEST_METHOD'] == "POST") {
  if(!isset($_SESSION['token'])) {
    $data = json_decode(file_get_contents("php://input"), true);

    $errors = [];
  
    foreach ($data as $key => $value) {
      $value = trim($value);
  
      if ($value === "" && !in_array("Polje ne moze biti prazno.", $errors)) {
        $errors[] = "Polje ne moze biti prazno.";
      }
  
      $specialCharacters = '/[^\w\s]/';
      $emailRegex = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
      $HTMLTagRegex = '/<\/?[\w\s]*>|<.+[\W]>/';
  
      // Filter HTML tags
      if (preg_match($HTMLTagRegex, $value)) {
        $errors[] = "Cannot submit html tags.";
      }
  
      // Validate username or email
      if ($key === "username") {
        if (strlen($value) < 3) {
          $errors[] = "Korisnicko ime mora sadrzati vise od 3 karaktera.";
        }
        if (strpos($value, " ") !== false) {
          $errors[] = "Korisnicko ime ne moze sadrzati razmak.";
        }
  
        if (preg_match($specialCharacters, $value)) {
          $errors[] = "Korisnicko ime ne moze sadrzati ni jedan specijalan karakter sem _";
        }
      }
  
      if ($key === "password") {
        // Validate password
        if (strpos($value, " ") !== false) {
          $errors[] = "Lozinka ne moze sadrzati razmake.";
        }
        if (strlen($value) < 3) {
          $errors[] = "Lozinka mora sadrzati najmanje 3 karaktera.";
        }
      }
    }
  
  
    // Output errors
    if(count($errors) > 0) {
      $errors = ["errors" => $errors];
      echo json_encode($errors);
      die();
    }
  
    $user = new User();
  
    echo json_encode($user->login($data));
  
    die();
  } else header("Location: /home");
}
