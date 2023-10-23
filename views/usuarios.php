<?php 
require_once('templates/header.php'); 
require_once('utils/gerar_csrf_token.php');
?>
<main class="home_content">

    <h1>Usuário</h1>

    <div class="content">
        <div class="add">
            <?php  if (isset($_SESSION['status'])): ?>
            <div class="status-message <?= $_SESSION['status'] ?>"><?= $_SESSION['status_message'] ?></div>
            <?php endif; ?>
            <div>
                <a href="#!" class="button" onclick="openModalCreate()">+</a>
            </div>
        </div>
        
        <section>
            <table class="content-table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Criação em</th>
                        <th>Atualizado em</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultData as $user) : ?>
                        <tr>
                            <td>
                                <?= $user->id ?>
                            </td>
                            <td>
                                <?= $user->name ?>
                            </td>
                            <td>
                                <?= $user->email ?>
                            </td>
                            <td>
                                <?= date("d-m-Y H:i:s", strtotime($user->created_at)) ?>
                            </td>
                            <td>
                                <?= $user->updated_at != "" ? date("d-m-Y H:i:s", strtotime($user->updated_at)) : '' ?>
                            </td>
                            <td>
                                <div style="display: flex; justify-content: space-evenly">
                                    <a href="#!" onclick="openModalEdit(<?= $user->id ?>)">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <a href="#!" onclick="openModalDelete(<?= $user->id ?>)">
                                    <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <?php if($totalPaginas > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                <a href="?route=usuarios&page=<?= $i ?>" class="<?= $page == $i ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
        
    </div>
</main>

<!-- Modal criação de usuários -->
<section>
    <div class="modal" id="userModal">
        <div class="modal-content">
            <button class="close-button" onclick="closeModalCreate()">X</button>
            <h2>Cadastro de Usuário</h2>
            <form action="?route=users/create" method="post">
                <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
                <div>
                    <input type="text" name="name" id="nome" placeholder="Digite o nome">
                </div>
                <div>
                    <input type="email" name="email" id="email" placeholder="Digite o email">
                </div>
                <div>
                    <input type="password" name="password" id="senha" placeholder="Digite a senha">
                </div>
                <div>
                    <input type="submit" value="Salvar"></input>
                    <button class="close" type="button" onclick="closeModalCreate()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Fim modal criação de usuários -->

<!-- Modal edição de usuários -->
<section>
    <?php foreach ($resultData as $user) : ?>
        <div class="modal" id="userModalEdit_<?= $user->id ?>">
            <div class="modal-content">
                <button class="close-button" onclick="closeModalEdit(<?=$user->id?>)">X</button>
                <h2>Editar Usuário</h2>
                <form action="?route=users/update" method="post">
                    <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
                    <input type="hidden" name="id" value="<?= $user->id ?>">
                    <div>
                        <input type="text" name="name" id="nome" placeholder="Digite o nome" value="<?= $user->name ?>">
                    </div>
                    <div>
                        <input type="email" name="email" id="email" placeholder="Digite o email" value="<?= $user->email ?>">
                    </div>
                    <div>
                        <input type="submit" value="Atualizar"></input>
                        <button class="close" type="button" onclick="closeModalEdit(<?=$user->id?>)">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</section>
<!-- Fim modal edição de usuários -->

<!-- Modal deleção de usuários -->
<section>
    <?php foreach ($resultData as $user) : ?>
        <div class="modal" id="userModalDelete_<?= $user->id ?>">
            <div class="modal-content">
                <button class="close-button" onclick="closeModalDelete(<?=$user->id?>)">X</button>
                <h2>Deletar usuário: <?= $user->name ?></h2>
                <form action="?route=users/delete" method="post">
                    <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
                    <input type="hidden" name="id" value="<?= $user->id ?>">
                    <div>
                        <input type="submit" value="Excluir"></input>
                        <button class="close" type="button" onclick="closeModalDelete(<?=$user->id?>)">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</section>
<!-- Fim modal criação de usuários -->

<script src="views/js/modals.js"></script>

<?php 
include("templates/footer.php"); 
unset($_SESSION['status']);
?>