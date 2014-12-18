<?php

//start a session
session_start();

// start autoloader
require_once __DIR__ . '/framework/autoloader.php';

$autoloader = new Framework\Autoloader();

spl_autoload_register(array($autoloader, 'loadFramework'));
spl_autoload_register(array($autoloader, 'loadApp'));

// redirect to the index page for the url manager to work
$redirect = new Framework\Redirect();
$redirect->toIndex();

// routes for the application -- Controller@function
$routes = array(
    "index"         => "HomeController@getIndex",
    "home"          => "HomeController@getIndex",
    "post-login"    => "UserController@postLogin",
    "post-register" => "UserController@postRegister",
    "login"         => "UserController@getLogin",
    "register"      => "UserController@getRegister",
    "logout"        => "UserController@getLogout",
    "update"        => "UserController@getUpdate",
    "post-update"   => "UserController@postUpdate"
);

$routing = new Framework\Route($routes);
$routing->route($_GET['r']);