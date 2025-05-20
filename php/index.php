<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';

$app = AppFactory::create();

$app->get('/alunni', "AlunniController:index");

$app->get('/alunni/{id}', "AlunniController:show");

$app->post('/alunni', "AlunniController:create");

$app->put('/alunni/{id}', "AlunniController:update");

$app->delete('/alunni/{id}', "AlunniController:destroy");

$app->get('/search/alunni/{key}', "AlunniController:filtro");

$app->get('/sort/alunni/{col}', "AlunniController:riordina");


$app->get('/alunni/{id}/cert', "AlunniController:show_cert");

$app->get('/alunni/{id}/cert/{id_cert}', "AlunniController:show_cert_specific");

$app->post('/alunni/{id}/cert', "AlunniController:create_cert");

$app->put('/alunni/{id}/cert/{id_cert}', "AlunniController:update_cert");

$app->run();