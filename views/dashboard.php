<?php 
include("templates/header.php"); ?>

    <main class="home_content">
        <header>
            <h1>Dashboard</h1>
        </header>
        <div class="container">
            <div class="card flex-item">
                <i class="fa-solid fa-user-doctor fa-3x"></i>
                <h2>Médicos <br> cadatrados</h2>
                <p>Total de médicos: 40 <br>
                Médicos disponíveis: 10</p>
            </div>
            <div class="card flex-item">
                <i class="fa-solid fa-stethoscope fa-3x"></i>
                <h2>Consultas <br> em Aberto </h2>
                <p>Consultas: 50</p>
            </div>
            <div class="card flex-item">
                <i class="fa-regular fa-hospital fa-3x"></i>
                <h2>Consultas Agendadas</h2>
                <p>Consultas: 20</p>
            </div>
            <div class="card flex-item">
                <i class="fa-solid fa-hospital-user fa-3x"></i>
                <h2>Exames <br> Agendados</h2>
                <p>Exames: 10</p>
            </div>
        </div>
    </main>

<?php
include("templates/footer.php");
unset($_SESSION['status']);
?>

