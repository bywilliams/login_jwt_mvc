<?php

// Gera um novo token CSRF
$newCsrfToken = bin2hex(random_bytes(32)); // 64 caracteres aleatórios

// Armazene o token na sessão
$_SESSION['csrf_token'] = $newCsrfToken;

?>