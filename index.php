<?php
require_once('controllers/UserController.php');

/// Array associativo das rotas
$routes = [
    'GET' => [
        '/' => 'UserController@index',
        'dashboard' => 'UserController@dashboard',
        'usuarios' => 'UserController@listUsers',
        'logout' => 'UserController@logout'
    ],
    'POST' => [
        'login' => 'UserController@validarUser',
        'users/create' => 'UserController@create',
        'users/update' => 'UserController@update',
        'users/delete' => 'UserController@delete'
    ]
];

// Obtem o método HTTP da requisição
$requestMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

// Obtem a rota da URL
$route = filter_input(INPUT_GET, 'route') ?? '/';

// Verifica o tipo de requisição e se a rota existe no array de rotas
if (array_key_exists($requestMethod, $routes) && array_key_exists($route, $routes[$requestMethod])) {
    
    // Dividi a string controller@action em 2 partes e armmazenas em 2 variáveis
    list($controllerName, $action) = explode('@', $routes[$requestMethod][$route]);

    // Verifica se a classe do controlador existe
    if (class_exists($controllerName)) {

        // Cria o objeto do controlador com base no nome do controlador
        $controller = new $controllerName();

        // Verifica se o método da action existe na classe do controlador
        if (method_exists($controller, $action)) {
            // Chama a action apropriada no controlador
            $controller->{$action}();
        } else {
            // A action especificada não existe no controlador
            require_once('views/404.php');
        }
    } else {
        // A classe do controlador especificada não existe
        require_once('views/404.php');
    }
} else {
    // Rota não encontrada para o método HTTP especificado
    require_once('views/404.php');
}



