// Script Modal de criação
function openModalCreate() {
    var modal = document.getElementById('userModal');
    modal.style.display = 'block';
}

function closeModalCreate() {
    var modal = document.getElementById('userModal');
    modal.style.display = 'none';
}
// Fim Script Modal de criação

// Script Modal Edit
function openModalEdit(i) {
    var modal = document.getElementById('userModalEdit_' + i);
    modal.style.display = 'block';
}

function closeModalEdit(i) {
    var modal = document.getElementById('userModalEdit_' + i);
    modal.style.display = 'none';
}
// Fim Script Modal Edit 


// Script Modal Edit
function openModalDelete(i) {
    var modal = document.getElementById('userModalDelete_' + i);
    modal.style.display = 'block';
}

function closeModalDelete(i) {
    var modal = document.getElementById('userModalDelete_' + i);
    modal.style.display = 'none';
}
// Fim Script Modal Edit 
