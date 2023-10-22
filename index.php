<?php
require_once('./controllers/UserController.php');


// Define um array associativo para mapear rotas e métodos HTTP
$routes = array(
    'GET' => array(
        '/' => array('controller' => 'UserController', 'action' => 'index'),
        'dashboard' => array('controller' => 'UserController', 'action' => 'dashboard'),
        'usuarios' => array('controller' => 'UserController', 'action' => 'listUsers'),
        'logout' => array('controller' => 'UserController', 'action' => 'logout'),
        
    ),
    'POST' => array(
        // 'create' => array('controller' => 'ClientsControllers', 'action' => 'create'),
        'users/update' => array('controller' => 'UserController', 'action' => 'update'),
        'login' => array('controller' => 'UserController', 'action' => 'validarUser'),
        'users/create' => array('controller' => 'UserController', 'action' => 'create'),
        'users/delete' => array('controller' => 'UserController', 'action' => 'delete'),
        
    )
);

// Obtem o método HTTP da requisição
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Obtem a rota da URL
$route = !empty($_GET['route']) ? $_GET['route'] : '/';

// Verifica se a rota especificada e o método HTTP existem no array de rotas
if (array_key_exists($requestMethod, $routes) && array_key_exists($route, $routes[$requestMethod])) {
    
    $controllerName = $routes[$requestMethod][$route]['controller'];
    $action = $routes[$requestMethod][$route]['action'];

    // Cria o objeto do controlador com base no nome do controlador
    $controller = new $controllerName();

    // Chama a action apropriada no controlador
    $controller->{$action}();
} else {
    // Rota não encontrada para o método HTTP especificado
    echo "Rota não encontrada para o método $requestMethod"; exit;
}
?>


