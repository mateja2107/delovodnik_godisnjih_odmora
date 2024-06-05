<?php
session_start();

if(isset($_SESSION['token'])) {
  foreach ($_COOKIE as $key => $value) {
    setcookie($key, '', time() - 1, '/');
  }
  
  session_destroy();
}

header("Location: /");