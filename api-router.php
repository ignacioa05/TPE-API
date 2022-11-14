<?php
require_once './libs/Router.php';
require_once './app/controllers/Product-api.controller.php';

// crea el router
$router = new Router();

// defina la tabla de ruteo
$router->addRoute('produc', 'GET', 'ProducApiController', 'getProducAll');//punto 2 tpe
$router->addRoute('produc/:ID', 'GET', 'ProducApiController', 'getProduc');
$router->addRoute('produc/:ID', 'DELETE', 'ProducApiController', 'deleteProduc');
$router->addRoute('produc', 'POST', 'ProducApiController', 'insertProduc'); 

// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);