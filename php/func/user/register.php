<?php

if($_SERVER['REQUEST_METHOD'] == "POST") {
  $session = loadPage();

  if($session['status'] == 'admin') {
    $data = json_decode(file_get_contents("php://input"), true);

    $errors = [];

    foreach ($data as $key => $value) {
      // trim the value " asd " = "asd";
      $value = trim($value);

      // check if all inputs are filled except bio
      if ($value === "" && !in_array("Sva polja moraju biti popunjena.", $errors)) {
        $errors[] = "Sva polja moraju biti popunjena.";
      }
    

      $numbers = '/\d/';
      $letters = '/[a-zA-Z]/';
      $specialCharacters = '/[^\w\s]/';
      $emailRegex = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
      $HTMLTagRegex = '/<\/?[\w\s]*>|<.+[\W]>/';

      // filter HTML tags
      if (preg_match($HTMLTagRegex, $value)) {
        $errors[] = "Cannot submit html tags.";
      }

      // validate status
      if ($key === "status") {
        if ($value !== "user" && $value !== "admin") {
          $errors[] = "Korisnik mora biti radnik ili administrator.";
        }
      }

      // validate username
      if ($key === "username") {
        if (strpos($value, " ") !== false) {
          $errors[] = "Korisnicko ime ne moze da sadrzi razmake.";
        }
        if (strlen($value) < 3) {
          $errors[] = "Korisnicko ime mora sadrzati 3 ili vise karaktera";
        }

        // all special characters except _
        $validateUsernameRegex = '/[^\w\s_]/';
        if (preg_match($validateUsernameRegex, $value)) {
          $errors[] = "Korisnicko ime ne moze sadrzati ni jedan specijalni karakter sem _";
        }
      }

      // validate password
      if ($key === "password") {
        if (strpos($value, " ") !== false) {
          $errors[] = "Lozinka ne moze sadrzati razmake";
        }
        if (strlen($value) < 5) {
          $errors[] = "Lozinka mora sadrzati 5 ili vise karaktera.";
        }
      }

      // validate e_code
      if($key === "e_code") {
        if (strpos($value, " ") !== false) {
          $errors[] = "Sifra radnika ne moze sadrzati razmake";
        }
        if (strlen($value) > 4) {
          $errors[] = "Sifra radnika mora sadrzati 4 ili manje karaktera.";
        }
        if(preg_match($letters, $value)) {
          $errors[] = "Sifra radnika ne moze da sadrzi slova.";
        }
        if(preg_match($specialCharacters, $value)) {
          $errors[] = "Sifra radnika ne moze da sadrzi specijalne karaktere.";
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
    echo json_encode($user->register($data));

    die();
  } else header("Location: /");
}
