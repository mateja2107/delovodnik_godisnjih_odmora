<?php

$url = parse_url($_SERVER['REQUEST_URI']);

$uri = $url['path'];

if(array_key_exists('query', $url)) $query_string = $url['query'];

$routes = [
    "/" => "views/login.view.php",
    "/home" => "views/home.view.php",
    "/users" => "views/users.view.php",
    "/stats" => "views/stats.view.php",
    "/old_rescripts" => "views/old.view.php",
    "/login" => "func/login.php",
    "/register" => "func/user/register.php",
    "/logout" => "func/logout.php",
    "/get_users" => "func/user/get_users.php",
    "/edit_user" => "func/user/edit_user.php",
    "/delete_user" => "func/user/delete_user.php",
    "/get_rescripts" => "func/rescript/get_rescripts.php",
    "/create_rescript" => "func/rescript/create_rescript.php",
    "/edit_rescript" => "func/rescript/edit_rescript.php",
];

if(array_key_exists($uri, $routes)) {
    require $routes[$uri];
} else {
    require 'views/404.php';
}

