<?php
require_once('controllers/UserController.php');

// Define um array associativo para mapear rotas e métodos HTTP
$routes = array(
    'GET' => array(
        '/' => array('controller' => 'UserController', 'action' => 'index'),
        'dashboard' => array('controller' => 'UserController', 'action' => 'dashboard'),
        'usuarios' => array('controller' => 'UserController', 'action' => 'listUsers'),
        'logout' => array('controller' => 'UserController', 'action' => 'logout')
    ),
    'POST' => array(
        'login' => array('controller' => 'UserController', 'action' => 'validarUser'),
        'users/create' => array('controller' => 'UserController', 'action' => 'create'),
        'users/update' => array('controller' => 'UserController', 'action' => 'update'),
        'users/delete' => array('controller' => 'UserController', 'action' => 'delete')
    )
);

// Obtem o método HTTP da requisição
$requestMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

// Obtem a rota da URL
$route = filter_input(INPUT_GET, 'route') ?? '/';

// Verifica o tipo de requisição e se a rota existe no array de rotas
if (array_key_exists($route, $routes[$requestMethod]) && array_key_exists($requestMethod, $routes)) {
    
    $controllerName = $routes[$requestMethod][$route]['controller'];
    $action = $routes[$requestMethod][$route]['action'];

    // Cria o objeto do controlador com base no nome do controlador
    $controller = new $controllerName();

    // Chama a action apropriada no controlador
    $controller->{$action}();
} else {
    // Rota não encontrada para o método HTTP especificado
    require_once('views/404.php');
}
?>


