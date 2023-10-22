<?php
    require_once('./vendor/autoload.php');

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '/../../.env');
    $dotenv->load();
    
    trait UserControllerTrait
    {

        function validarUser ()
        {
             // Checa se o @crsf token do form existe e é igual ao gerado na session
            if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
                setcookie('token', "");
                require_once ('./views/index.php');
                exit;
            }
            
            $email = strip_tags($_POST['email']);
            $password = strip_tags($_POST['password']);
            
            $userFound = $this->model->checkUser($email);
            
            if (!$userFound) 
            {
                $_SESSION['status'] = 'error';
                $_SESSION['status_message'] = 'E-mail e/ou senha inválidos.';
                require_once ('./views/index.php');
                exit;
            } 
            
            if(!password_verify($password, $userFound->password))
            {
                $_SESSION['status'] = 'error';
                $_SESSION['status_message'] = 'E-mail e/ou senha inválidos.';
                require_once ('./views/index.php');
                exit;
            }

            try 
            {
                $this->gerarToken($email, $userFound->name, $userFound->nivel_acesso);                
            } 
            catch (Exception $e) 
            {
                http_response_code(401);
                echo json_encode(['Error'=> 'credenciais invalidas' . $e->getMessage()]);
            }

        }

        function gerarToken($email, $username, $nivel_acesso) 
        {

            $header = [
                'alg' => 'HS256',
                'type' => 'JWT'
            ];

            // duração do token 15 minutos
            $duration = time() + (15 * 60);

            $payload = [
                'exp' => $duration,
                'iat' => time(),
                'email' => $email,
                'username' => $username,
                'nivel_acesso' => $nivel_acesso
            ];

            function base64url_encode($data) {
                return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
            }

            // Codificar o cabeçalho e a carga útil para Base64 URL
            $header = base64url_encode(json_encode($header));
            $payload = base64url_encode(json_encode($payload));

            //gerar assinatura
            $signature = hash_hmac('sha256', "$header.$payload", $_ENV['KEY']);

            $signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

            // Monta o JWT final
            $token = "$header.$payload.$signature";
            setcookie('token', $token);
            $_SESSION['token'] = $token;

            $this->dashboard();
            
        }

        function validarToken ()
        {
            $token =  $_SESSION['token'];

            $tokenArray = explode('.', $token);

            $header = $tokenArray[0];
            $payload = $tokenArray[1];
            $provided_signature = $tokenArray[2];

            // Calcula a assinatura esperada
            $expectedSignature = hash_hmac('sha256', "$header.$payload", $_ENV['KEY']);
            
            // codifica para base64
            $expectedSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($expectedSignature));
            
            // Verifica se assinatura fornecida é igual à esperada
            if ($provided_signature == $expectedSignature) {
                
                // verificar tempo de expiração do token
                $dadosToken = base64_decode($payload);
                $dadosToken = json_decode($dadosToken);

                if($dadosToken->exp > time()) {
                    return true;
                } else {
                    setcookie('token', '');
                    $_SESSION['status'] = 'error';
                    $_SESSION['status_message'] = 'Token inválido/expirado faça login novamente.';
                    header('Location: ./index.php');
                    exit;
                }

            } else {
                setcookie('token', '');
                $_SESSION['status'] = 'error';
                $_SESSION['status_message'] = 'Token inválido/expirado faça login novamente.';
                header('Location: ./index.php');
                exit;
            }
            
            
        }

        function password_strength($password){
	
            //validate password strength
            $uppercase = preg_match("@[A-Z]@", $password);
            $lowercase = preg_match("@[a-z]@", $password);
            $number = preg_match("@[0-9]@", $password);
            $specialChars = preg_match("@[^\w]@", $password);
        
            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                return false;
            }else {
                return true;
            }
        
        }

    }
