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
        <h2>Login</h2>
        <img src="" alt="">
        <form id="form" action="?route=login" method="post">
            <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
            <div class="form-group">
                <label for="username">E-mail</label>
                <input type="text" name="email" placeholder="Seu melhor email" value="william@teste.com" required>
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" name="password" placeholder="Sua melhor senha" value="Orion$97" required>
            </div>
            <button class="btn-submit" type="submit">Login</button>
        </form>
    </div>

</body>
</html>
<?php unset($_SESSION['status']);?> 