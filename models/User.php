<?php 

    require_once('./configuration/connect.php');

    class UserModel extends Connect
    {
        private $table;

        private $id;
        private $name;
        private $email;


        function __construct()
        {
            parent::__construct(); // invoca da classe pai Connect
            $this->table = 'users';
        }

        function getAll($inicio, $itensPorPagina)
        {
            // Obtem os registros da página atual
            $sqlSelect = $this->connection->query("SELECT id, name, email, created_at, updated_at 
                                                    FROM $this->table LIMIT $inicio, $itensPorPagina");
            $resultQuery = $sqlSelect->fetchAll(PDO::FETCH_OBJ);

            // Consulta para obter o total de registros na tabela
            $sqlCount = $this->connection->query("SELECT COUNT(*) as total FROM $this->table");
            $totalRegistros = $sqlCount->fetch(PDO::FETCH_ASSOC)['total'];
            
            return array(
                'data' => $resultQuery,
                'totalRegistros' => $totalRegistros
            );
        }

        function checkUser($email) 
        {
            $sqlSelect = $this->connection->prepare("SELECT usr.id, usr.name, usr.email, usr.password, al.title AS 'nivel_acesso'
                                                    FROM $this->table usr
                                                    INNER JOIN access_level al ON usr.access_level_id = al.id
                                                    WHERE email = :email");
            $sqlSelect->execute([
                'email' => $email
            ]);
            $resultQuery = $sqlSelect->fetch();

            return $resultQuery;
        }

        function create($formData)
        {

            $user = new UserModel();
            $user->checkUser($formData["email"]);

            $password = password_hash($formData["password"], PASSWORD_DEFAULT);

            $sqlCreate = $this->connection->prepare("INSERT INTO $this->table
            (name, email, password, created_at) VALUES (:name, :email, :password, NOW())");
            $sqlCreate->bindParam(":name", $formData['name'],  PDO::PARAM_STR);
            $sqlCreate->bindParam(":email", $formData['email'], PDO::PARAM_STR);
            $sqlCreate->bindParam(":password", $password, PDO::PARAM_STR);
            
            try 
            {
                $sqlCreate->execute();
                $_SESSION['status'] = 'success';
                $_SESSION['status_message'] = 'Usuário cadastrado com sucesso!';
            } 
            catch (PDOException $e) 
            {
                $_SESSION['status'] = 'error';
                $_SESSION['status_message'] = 'Erro ao criar usuário consulte o administrador do sistema!';
                //echo 'Error: '. $e->getMessage();
            }

        }

        function update($formData)
        {
            $sqlSelect = $this->connection->prepare("SELECT id, name, email, password FROM $this->table WHERE id = :id");
            $sqlSelect->execute([
                'id' => $formData['id']
            ]);
            $userFound = $sqlSelect->fetch();

            if (isset($formData['csrf_token'])) {
                unset($formData['csrf_token']);
            }

            foreach ($formData as $key => $value) {

                if($value !== $userFound->$key) {
                    $this->$key = $value;
                } else if($key != 'csrf_token') {
                    $this->$key = $userFound->$key;
                }
            }

            //exit;

            $sqlUpdate = $this->connection->prepare("UPDATE $this->table
            SET name = :name, email = :email, updated_at = NOW() WHERE id = :id");
            $sqlUpdate->bindParam(":name", $this->name);
            $sqlUpdate->bindParam(":email", $this->email);
            $sqlUpdate->bindParam(":id", $this->id);

            try 
            {
                $sqlUpdate->execute();
                $_SESSION['status'] = 'success';
                $_SESSION['status_message'] = 'Usuário atualizado com sucesso!';
            } 
            catch (PDOException $e) 
            {
                $_SESSION['status'] = 'error';
                $_SESSION['status_message'] = 'Erro ao atualizar usuário, consulte o administrador do sistema!';
                //echo 'Error: '. $e->getMessage();
            }

        }

        function delete ($id)
        {
            $sqlDelete = $this->connection->prepare("DELETE FROM $this->table WHERE id = :id");
            $sqlDelete->bindParam(":id", $id, PDO::PARAM_INT);
            try{
                $sqlDelete->execute();
                $_SESSION['status'] = 'success';
                $_SESSION['status_message'] = 'Usuário deletado com sucesso!';
            }
            catch (PDOException $e)
            {
                $_SESSION['status'] = 'Error';
                $_SESSION['status_message'] = 'Erro ao deletar usuário, consulte o administrador do sistema!';
                //echo "Error: " . $e->getMessage();
            }
            
        } 

    }


?>