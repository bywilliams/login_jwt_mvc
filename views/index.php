<?php require_once("utils/gerar_csrf_token.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./views/css/index.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <?php  if (isset($_SESSION['status'])): ?>
        <div class="status-message <?= $_SESSION['status'] ?>"><?= $_SESSION['status_message'] ?></div>
        <?php endif; ?>
        <div>
            <img src="views/assets/hospital.svg" alt="hospital_svg" width="200" height="150">
        </div>
        <h2>Login</h2>
        <form id="form" action="?route=login" method="post">
            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
            <div class="form-group">
                <label for="username">E-mail</label>
                <input type="text" name="email" value="" required>
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" name="password" value="" required>
            </div>
            <button class="btn-submit" type="submit">Login</button>
        </form>
    </div>

</body>
</html>
<?php unset($_SESSION['status']);?> 
