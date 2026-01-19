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
$routes->get('/clientes/clientes_cadastro/(:num)', 'Clientes::clientes_cadastro/$1');
//$routes->get('/clientes/cadastrar/(:num)', 'Clientes::cadastrar/$1');
$routes->post('/clientes/salvar', 'Clientes::salvar');
$routes->get('/clientes/listar', 'Clientes::listar');
$routes->delete('/clientes/excluir/(:num)', 'Clientes::excluir/$1');
$routes->get('/clientes/restaurar/(:num)', 'Clientes::restaurarClienteExcluido/$1');
//$routes->get('clientes/cadastro/(:num)', 'Clientes::cadastro/$1');

$routes->get('/pedidos', 'Pedidos::pedidos');
$routes->get('/pedidos/pedidos_cadastro', 'Pedidos::pedidos_cadastro');
$routes->get('/pedidos/cadastrar', 'Pedidos::cadastrar');

$routes->get('/produtos', 'Produtos::produtos');
$routes->get('/produtos/produtos_cadastro', 'Produtos::produtos_cadastro');
$routes->get('/produtos/cadastrar', 'Produtos::cadastrar');

$routes->get('/configuracoes', 'Configuracoes::configuracoes');
