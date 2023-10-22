<?php 
    session_start();
    require_once ('./models/User.php');
    require_once ('traits/UserControllerTrait.php');

    class  UserController
    {
        use UserControllerTrait;
        private $model;

        function __construct ()
        {
            $this->model = new UserModel();
        }

        function index()
        {
            require_once('./views/index.php');
        }

        function dashboard()
        {
            $userController = new UserController();
            $dadosUser = $userController->getUserName();
          
            $userController->validarToken();
            require_once('./views/dashboard.php');
        }

        function listUsers ()
        {
            $userController = new UserController();
            $dadosUser = $userController->getUserName();

            $resultData = $this->model->getAll();
            //var_dump($resultData); exit;
            require_once ('./views/usuarios.php');
        }

        function create ()
        {
            // Checa se o @crsf token do form existe e é igual ao gerado na session
            if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
                require_once ('./views/dashboard.php');
                exit;
            }

            $formData = $_POST;
            $email = $formData['email'];
            $userExists = $this->model->checkUser($email);

            // se usuário não existir insere na tabela
            if (!$userExists) {

                // se não passar pela validação da senha apresenta erro, do contrário salva no BD 
                if(!$this->password_strength($formData['password'])) {
                    $_SESSION['status'] = 'error';
                    $_SESSION['status_message'] = 'A senha deve ter no minímo 8 caracteres, sendo 1 letra maíscula, 1 numero e 1 simbolo';
                } else {
                    $this->model->create($formData);
                }

            } else {
                $_SESSION['status'] = 'error';
                $_SESSION['status_message'] = 'Usuário já existe!';
            }

            $userController = new UserController();
            $userController->listUsers();
        }

        function update ()
        {
            if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
                require_once ('./views/dashboard.php');
                exit;
            }

            $formData = $_POST;
            $this->model->update($formData);

            $userController = new UserController();
            $userController->listUsers();
        }

        function delete ()
        {
            if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
                require_once ('./views/dashboard.php');
                exit;
            }

            $id = $_POST['id'];
            $this->model->delete($id);

            $userController = new UserController();
            $userController->listUsers();
        }       

        function getUserName ()
        {
            if(isset($_SESSION['token'])){
                $token = $_SESSION['token'];
                $tokenArray = explode('.', $token);
                $payload = $tokenArray[1];
    
                $payload = base64_decode($payload);
                $payload = json_decode($payload);
    
                return $payload;
            } else {
                return '';
            }

        }

        function logout ()
        {
            if(isset($_COOKIE['token'])){
                setcookie('token', '');
                $_SESSION['status'] = 'success';
                $_SESSION['status_message'] = 'Logoff efetuado com sucesso!';
                header('Location: ./index.php');
                exit;
            }
        }

    }