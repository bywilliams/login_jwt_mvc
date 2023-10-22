<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard com Sidebar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="views/css/dashboard.css">
</head>
<body>

    <div class="menu-icon" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </div>

    <aside class="sidebar" id="sidebar">
        <div class="user-profile">
            <div class="user-info">
                <div class="user-name"><?= isset($dadosUser->username) ? $dadosUser->username : '' ?></div>
                <div class="welcome-message">Bem-vindo!</div>
            </div>
        </div>
        <a href="./?route=dashboard"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <?php if(isset($dadosUser->nivel_acesso) && $dadosUser->nivel_acesso == 'Administrador'): ?>
            <a href="./?route=usuarios"><i class="fa-solid fa-people-group"></i> Usuários</a>
        <?php endif; ?>
        <a href="./?route=logout"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
    </aside>