<?php 
include("templates/header.php"); ?>
<style>
    .card{
        background-color: #C1D8C3;
        border-radius: 10px;
        padding: 10px;
    }

    .container {
        display:flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .flex-item {
        flex-grow: 1;
        flex-basis: 200px;
    }
</style>
    <main class="home_content">
        <header>
            <h1>Dashboard</h1>
        </header>
        <div class="container">
            <div class="card flex-item">
                <h2>Médicos</h2>
                <p>Total de médicos: 40 <br>
                Médicos disponíveis: 10</p>
            </div>
            <div class="card flex-item">
                <h2>Consultas Abertas</h2>
                <p>Consultas: 50</p>
            </div>
            <div class="card flex-item">
                <h2>Consultas Agendadas</h2>
                <p>Consultas: 20</p>
            </div>
            <div class="card flex-item">
                <h2>Exames Agendados</h2>
                <p>Exames: 10</p>
            </div>
        </div>
    </main>

<?php
include("templates/footer.php");
unset($_SESSION['status']);
?>

