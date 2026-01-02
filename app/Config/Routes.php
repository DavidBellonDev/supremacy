<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Index::index');
$routes->get('/login', 'Index::login');
$routes->get('/cadastre_se', 'Index::cadastre_se');
$routes->get('/home', 'Home::home');
$routes->get('/clientes', 'Clientes::clientes');
$routes->get('/vendas', 'Vendas::vendas');
$routes->get('/produtos', 'Produtos::produtos');
$routes->get('/configuracoes', 'Configuracoes::configuracoes');
