<?php
require_once('models/Clients.php');
require_once('libs/Utils.php');
require_once('config/config.php');

 $di = new \Phalcon\DI\FactoryDefault();
 $di->set('db', function(){
     return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => HOST,
        "username" => USERNAME,
        "password" => PASSWORD,
        "dbname" => DBNAME
    ));
});

$app = new \Phalcon\Mvc\Micro($di);

$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo 'This is crazy, but this page was not found!';
});

$app->get('/clients/add', function() use ($app) {

    $name = trim($_GET['name']);
    $lastName = trim($_GET['lastName']);
    $age = trim($_GET['age']);

    // Adds a new user
    $query = "INSERT INTO Clients(name, lastname, age) VALUES('$name', '$lastName', '$age')";
    $clients = $app->modelsManager->executeQuery($query);

    response($_GET['callback'], $clients);

});

$app->get('/clients', function () use ($app){

    $clients = Clients::query()
            ->order("name")
            ->execute()
            ->toArray();

    response($_GET['callback'], $clients);

});

$app->get('/clients/remove', function () use ($app){

    $id = $_GET['id'];

    $query = "DELETE FROM Clients WHERE id = $id";
    $clients = $app->modelsManager->executeQuery($query);

    response($_GET['callback'], $clients);

});

$app->handle();
