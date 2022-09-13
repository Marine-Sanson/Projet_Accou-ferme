<?php

// initialise la session
session_start();

// si il n'y a pas de panier, en initialise un
if(!isset($_SESSION["basket"]))
{
    $_SESSION["basket"] = [];
}

require "managers/AbstractManager.php";
require "autoload.php";

try {

    $router = new Router();

    if(isset($_GET['path']))
    {
        $request = "/".$_GET['path'];
    }
    else
    {
        $request = "/";
    }

    $router->route($routes, $request);
}
catch(Exception $e)
{
    if($e->getCode() === 404)
    {
        
        $template="404";
        require "./templates/layout.phtml";
        
    }
}