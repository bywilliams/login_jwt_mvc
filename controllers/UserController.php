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
            // Chama view login
            require_once('./views/index.php');
        }

        function dashboard()
        {
            $dadosUser = $this->getUserName();

            // verifica se token está válido
            $_SESSION['token'] == $_COOKIE['token'] ? $this->validarToken() : '';
            
            // Chama view dashboard
            require_once('./views/dashboard.php');
        }

        function listUsers ()
        {
            $dadosUser = $this->getUserName();
            $this->validarToken();

            // Ler o parâmetro da página da URL
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $itensPerPage = 5;
            
            // Calcula o índice de inicio e fim dos dados para a pagina atual
            $inicio = ($page - 1) * $itensPerPage;

            $paginateData = $this->model->getAll($inicio, $itensPerPage);
            $resultData = $paginateData['data'];

            // Total de registros na tabela
            $totalRegistros = $paginateData['totalRegistros'];

            // Calcular o número total de páginas
            $totalPaginas = ceil($totalRegistros / $itensPerPage);

            require_once ('./views/usuarios.php');
        }

        function create ()
        {
            // Checa se o @crsf token do form existe e é igual ao gerado na session
            if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
                setcookie('token', "");
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
            
            // Chama view usuários
            $this->listUsers();
        }

        function update ()
        {
            if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
                require_once ('./views/dashboard.php');
                exit;
            }

            // Realiza update
            $formData = $_POST;
            $this->model->update($formData);

            // chama view usuários
            $this->listUsers();
        }

        function delete ()
        {
            if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
                require_once ('./views/dashboard.php');
                exit;
            }

            // Realiza delete
            $id = $_POST['id'];
            $this->model->delete($id);

            // Chama view usuários
            $this->listUsers();
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