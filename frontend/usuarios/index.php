<?php
$titulo = 'Administración de usuarios';
$clase = 'bg-warning';
include_once '../vendor/inicio.html';
?>
<div class="container my-5">
    <div id="responseMessage"></div>
    <form id="userForm" class="mb-4">
        <input type="hidden" id="id">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="email">Correo</label>
                <input class="form-control" id="email" type="email" required>
            </div>
            <div class="form-group col-md-4">
                <label for="nombre">Nombre</label>
                <input class="form-control" id="nombre" required>
            </div>
            <div class="form-group col-md-4">
                <label for="password">Contraseña (vacío = conservar)</label>
                <input class="form-control" id="password" type="password">
            </div>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" id="isAdmin" type="checkbox">
            <label class="form-check-label" for="isAdmin">Administrador</label>
        </div>
        <button class="btn btn-primary" type="submit">Guardar usuario</button>
        <button class="btn btn-secondary" id="cancelButton" type="button">Limpiar</button>
    </form>
    <table class="table table-bordered" id="usersTable">
        <thead><tr><th>Nombre</th><th>Correo</th><th>Administrador</th><th>Acciones</th></tr></thead>
        <tbody></tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    const usersEndpoint = '<?= $URL_BASE ?>usuarios/admin.php';
    const form = document.getElementById('userForm');
    const message = document.getElementById('responseMessage');
    const tbody = document.querySelector('#usersTable tbody');

    function showMessage(text, type = 'success') {
        message.innerHTML = `<div class="alert alert-${type}">${text}</div>`;
    }

    function loadUsers() {
        fetch(usersEndpoint).then(response => response.json().then(data => ({ response, data })))
            .then(({ response, data }) => {
                if (!response.ok) throw new Error(data.message || 'No se pudieron cargar los usuarios');
                tbody.innerHTML = data.map(user => `<tr>
                    <td>${user.nombre}</td>
                    <td>${user.email}</td>
                    <td>${Number(user.isAdmin) === 1 ? 'Sí' : 'No'}</td>
                    <td><button class="btn btn-sm btn-info edit-user" data-user='${JSON.stringify(user)}'>Editar</button></td>
                </tr>`).join('');
                document.querySelectorAll('.edit-user').forEach(button => {
                    button.addEventListener('click', () => {
                        const user = JSON.parse(button.dataset.user);
                        document.getElementById('id').value = user.id;
                        document.getElementById('email').value = user.email;
                        document.getElementById('nombre').value = user.nombre;
                        document.getElementById('isAdmin').checked = Number(user.isAdmin) === 1;
                        document.getElementById('password').value = '';
                    });
                });
            })
            .catch(error => showMessage(error.message, 'danger'));
    }

    form.addEventListener('submit', event => {
        event.preventDefault();
        const id = document.getElementById('id').value;
        const data = {
            email: document.getElementById('email').value,
            nombre: document.getElementById('nombre').value,
            password: document.getElementById('password').value,
            isAdmin: document.getElementById('isAdmin').checked
        };
        if (id) data.id = Number(id);
        fetch(usersEndpoint, {
            method: id ? 'PUT' : 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        }).then(response => response.json().then(payload => ({ response, payload })))
        .then(({ response, payload }) => {
            if (!response.ok) throw new Error(payload.message || 'No se pudo guardar');
            showMessage(payload.message);
            form.reset();
            document.getElementById('id').value = '';
            loadUsers();
        }).catch(error => showMessage(error.message, 'danger'));
    });

    document.getElementById('cancelButton').addEventListener('click', () => {
        form.reset();
        document.getElementById('id').value = '';
    });
    loadUsers();
</script>
<?php include_once '../vendor/fin.html'; ?>
