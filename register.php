<?php
include './templates/header.php';

if ($userController->isUserLoggedIn()) {
    header('Location: panel.php');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>

    <?php include './templates/nav.php' ?>

    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col col-md-6">
                <h3>Nueva cuenta</h3>
                <hr>

                <form id="register-form">
                    <div class="form-group">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" autocomplete="name">
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" autocomplete="email">
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password">
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Crear cuenta</button>
                    </div>
                </form>
                <div class="alert alert-danger mt-4 d-none" id="error-message"></div>
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.7/axios.min.js"></script>

    <script>
        document.getElementById('register-form').onsubmit = (e) => {
            e.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('error-message')

            errorMessage.classList.add('d-none');

            if (!name || !email || !password) {
                return;
            }

            axios.post('api/register.php', {
                    name: name,
                    email: email,
                    password: password
                })
                .then(result => {
                    //redireccionar al panel
                    window.location = 'panel.php';
                })
                .catch(error => {
                    errorMessage.innerText = error.response.data;
                    errorMessage.classList.remove('d-none');
                    //console.log(error.response.data);
                })
        }
    </script>

</body>

</html>