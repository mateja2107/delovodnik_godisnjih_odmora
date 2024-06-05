<?php

function dd($value) {
  echo "<pre>";
  var_dump($value);
  echo "</pre>";
}

function isDateBefore($date1, $date2) {
  return strtotime($date1) <= strtotime($date2);
}

// Function to check if the date is valid
function isValidDate($date) {
  return (bool) strtotime($date);
}

function query($conn, $sql, $params, $id = 0) 
{
    $query = $conn->conn->prepare($sql);

    // Bind parameters
    foreach($params as $key => $value) {
        // $query->bindParam(":{$key}", $value);
        $query->bindParam(":{$key}", $params[$key]);
    }
    
    if($id != 0) {
      $query->bindParam(':id', $id, PDO::PARAM_INT);
    }

    // Execute query
    return $query->execute();
}

function login()
{
  if (isset($_SESSION['token'])) {
    return true;

  } else if (isset($_COOKIE['token'])) {
    // $_SESSION['token'] = $_COOKIE['token'];
    // $_SESSION['id'] = $_COOKIE['id'];
    // $_SESSION['username'] = $_COOKIE['username'];
    // $_SESSION['e_code'] = $_COOKIE['e_code'];
    // $_SESSION['status'] = $_COOKIE['status'];

    return true;
    
  } else return false;
}

function generateRandomString($length = 100) 
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@';
    // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!#$%&()*+,.:;<=>?@[]^_`{|}~';
    $randomString = '';
    $max = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $max)];
    }

    $data = ["token" => $randomString];

    $sql = "SELECT * FROM users WHERE token = :token";

    $user = Connection::getData($sql, $data);

    if($user) {
        generateRandomString();
    } else return $randomString;
}

function loadPage() {
  if(!login()) {
    header("Location: /");
  }
  
  $user = new User();
  $user = $user->getUser($_SESSION['token']);

  return $user;
}

function calculateWorkDays($start, $end) {
  $workDays = 0;
  $currentDate = new DateTime($start);
  $endDate = new DateTime($end);

  // Iterate from start date to end date
  while ($currentDate <= $endDate) {
    $dayOfWeek = $currentDate->format('N');
    // Check if the current day is a weekday (Monday to Friday)
    if ($dayOfWeek >= 1 && $dayOfWeek <= 5) {
      $workDays++;
    }
    // Move to the next day
    $currentDate->modify('+1 day');
  }

  return $workDays;
}

function validate_rescript_data($data) {
  $errors = [];
  
  foreach ($data as $key => $value) {
    $value = trim($value);

    if ($value === "" && !in_array("Polje ne moze biti prazno.", $errors)) {
      $errors[] = "Polje ne moze biti prazno.";
    }

    $numbers = '/\d/';
    $letters = '/[a-zA-Z]/';
    $rescript_id_regex = '/^[0-9-]+$/';
    $specialCharacters = '/[^\w\s]/';
    $emailRegex = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
    $HTMLTagRegex = '/<\/?[\w\s]*>|<.+[\W]>/';

    // Filter HTML tags
    if (preg_match($HTMLTagRegex, $value)) {
      $errors[] = "Cannot submit html tags.";
    }

    if($key === "number") {
      if (!preg_match($numbers, $value)) {
        $errors[] = "Redni broj resenja mora sadrzati cifre.";
      }
      if (preg_match($letters, $value)) {
        $errors[] = "Redni broj resenja ne moze sadrzati slova.";
      }
      if (strpos($value, " ") !== false) {
        $errors[] = "Redni broj resenja ne moze da sadrzi razmak.";
      }
    }

    if ($key === "rescript_id") {
      if (strlen($value) > 10) {
        $errors[] = "Broj resenja ne moze biti duzi od 10 karaktera";
      }
      if (!preg_match($numbers, $value)) {
        $errors[] = "Broj resenja mora sadrzati cifre.";
      }
      if (preg_match($letters, $value)) {
        $errors[] = "Broj resenja ne moze sadrzati slova.";
      }
      if (strpos($value, " ") !== false) {
        $errors[] = "Broj resenja ne moze da sadrzi razmak.";
      }
      if (strpos($value, "-") === false) {
        $errors[] = "Broj resenja mora sadrzati -";
      }
    }

    if ($key === "rescript_year") {
      if (strlen($value) != 4) {
        $errors[] = "Godina resenja moze sadrzati samo 4 cifre.";
      }
      if (!preg_match($numbers, $value)) {
        $errors[] = "Godina resenja mora sadrzati cifre.";
      }
      if (preg_match($letters, $value)) {
        $errors[] = "Godina resenja ne moze sadrzati slova.";
      }
      if (strpos($value, " ") !== false) {
        $errors[] = "Godina resenja ne moze da sadrzi razmak.";
      }
    }

    if ($key === "e_code") {
      if (strpos($value, " ") !== false) {
        $errors[] = "Sifra radnika ne moze da sadrzi razmake.";
      }
      if (strlen($value) > 4) {
        $errors[] = "Sifra radnika ne moze da sadrzi vise od 4 cifre";
      }
      if (preg_match($letters, $value)) {
        $errors[] = "Sifra radnika ne moze da sadrzi slova.";
      }
      if (preg_match($specialCharacters, $value)) {
        $errors[] = "Sifra radnika ne moze da sadrzi specijalne karaktere.";
      }
    }

    if ($key === "e_name") {
      if (preg_match($numbers, $value)) {
        $errors[] = "Ime radnika ne moze da sadrzi brojeve.";
      }
      if (preg_match($specialCharacters, $value)) {
        $errors[] = "Ime radnika ne moze da sadrzi specijalne karaktere.";
      }
      if (strpos($value, " ") === false) {
        $errors[] = "Ime radnika mora sadrzati jedan razmak.";
      }
    }

    if ($key === "from_date" || $key === "to_date") {
      if (!DateTime::createFromFormat('Y-m-d', $value) && !in_array("Datum nije validan.", $errors)) {
        $errors[] = "Datum nije validan.";
      }
    }
  }

  if (!isDateBefore($data["from_date"], $data["to_date"])) {
    $errors[] = "Obratite paznju na format datuma kad ga upisujete. mesec / dan / godina";
  }

  // Output errors
  if(count($errors) > 0) {
    $errors = ["errors" => $errors];
    echo json_encode($errors);
    die();
  }
}

function validate_date($date) {
  $errors = [];

  $HTMLTagRegex = '/<\/?[\w\s]*>|<.+[\W]>/';
  $letters = '/[a-zA-Z]/';
  if (preg_match($HTMLTagRegex, $date)) {
    $errors[] = "Cannot submit html tags.";
  }
  if (preg_match($letters, $date)) {
    $errors[] = "Redni broj resenja ne moze sadrzati slova.";
  }
  if (strpos($date, " ") !== false) {
    $errors[] = "Redni broj resenja ne moze da sadrzi razmak.";
  }
  if($date === '') {
    $errors[] = "Polje ne moze biti prazno.";
  }

  // Output errors
  if(count($errors) > 0) {
    $errors = ["errors" => $errors];
    echo json_encode($errors);
    die();
  }
}

function isWithinLast24Hours($timestamp) {
  // Get the current time
  $currentTime = new DateTime();
  
  // Convert the timestamp to a DateTime object
  $timestampTime = new DateTime($timestamp);
  
  // Calculate the difference in hours
  $interval = $currentTime->diff($timestampTime);
  $hoursDifference = $interval->h + ($interval->days * 24);
  
  // Return true if the difference is less than or equal to 24 hours
  return $hoursDifference <= 24;
}