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
$routes->get('/clientes/clientes_cadastro', 'Clientes::clientes_cadastro');
$routes->get('/clientes/cadastrar', 'Clientes::cadastrar');

$routes->get('/pedidos', 'Pedidos::pedidos');
$routes->get('/pedidos/pedidos_cadastro', 'Pedidos::pedidos_cadastro');
$routes->get('/pedidos/cadastrar', 'Pedidos::cadastrar');

$routes->get('/produtos', 'Produtos::produtos');
$routes->get('/produtos/produtos_cadastro', 'Produtos::produtos_cadastro');
$routes->get('/produtos/cadastrar', 'Produtos::cadastrar');

$routes->get('/configuracoes', 'Configuracoes::configuracoes');
