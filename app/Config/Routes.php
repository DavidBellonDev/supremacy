<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Index::index');

//Login/Cadastro
$routes->get('/login', 'Index::login');
$routes->post('/logar', 'Index::logar');
$routes->get('/logout', 'Index::logout');
$routes->get('/cadastre_se', 'Index::cadastre_se');
$routes->get('/cadastre_empresa', 'Index::cadastre_empresa');
$routes->post('/index/salvar_empresa', 'Index::salvar_empresa');
$routes->get('/esqueci_senha', 'Index::esqueci_senha');
$routes->post('/recuperar_senha', 'Index::recuperar_senha');
$routes->get('nova-senha/(:segment)', 'Index::novaSenha/$1');
$routes->post('nova_senha', 'Index::salvarNovaSenha');

//Home
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/home', 'Home::home');
});

//Clientes
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/clientes', 'Clientes::clientes');
    $routes->get('/clientes/clientes_cadastro/(:num)', 'Clientes::clientes_cadastro/$1');
    $routes->post('/clientes/salvar', 'Clientes::salvar');
    $routes->get('/clientes/listar', 'Clientes::listar');
    $routes->delete('/clientes/excluir/(:num)', 'Clientes::excluir/$1');
    $routes->get('/clientes/restaurar/(:num)', 'Clientes::restaurarClienteExcluido/$1');
    $routes->get('/clientes/buscar_pedido', 'Clientes::buscar_pedido');
});

//Pedidos
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/pedidos', 'Pedidos::pedidos');
    $routes->get('/pedidos/pedidos_cadastro/(:num)', 'Pedidos::pedidos_cadastro/$1');
    $routes->get('/pedidos/cadastrar', 'Pedidos::cadastrar');
    $routes->post('/pedidos/salvar', 'Pedidos::salvar');
    $routes->get('/pedidos/listar', 'Pedidos::listar');
    $routes->delete('/pedidos/excluir/(:num)', 'Pedidos::excluir/$1');
});

//Itens
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->post('/itens/salvar', 'Itens::salvar');
    $routes->get('/itens/listar/(:num)', 'Itens::listar/$1');
    $routes->get('/itens/buscar_itens_pedido', 'Itens::buscar_itens_pedido');
    $routes->delete('/itens/excluir/(:num)', 'Itens::excluir/$1');
});

//Produtos
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/produtos', 'Produtos::produtos');
    $routes->get('/produtos/produtos_cadastro/(:num)', 'Produtos::produtos_cadastro/$1');
    $routes->post('/produtos/salvar', 'Produtos::salvar');
    $routes->get('/produtos/listar', 'Produtos::listar');
    $routes->delete('/produtos/excluir/(:num)', 'Produtos::excluir/$1');
    $routes->get('/produtos/restaurar/(:num)', 'Produtos::restaurarProdutoExcluido/$1');
});

//Configurações
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/configuracoes', 'Configuracoes::configuracoes');
    $routes->post('/configuracoes/atualizar_empresa', 'Configuracoes::atualizar_empresa');
});
