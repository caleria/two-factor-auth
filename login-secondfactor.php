<?php
include './templates/header.php';

if ($userController->isUserLoggedIn()) {
    header('Location: panel.php');
}

if (!(isset($_SESSION['isLoggedIn']) && isset($_SESSION['email']))){
    header('Location: login.php');
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
                <h3>Segundo factor de autenticacion</h3>
                <hr>

                <form id="second-factor-form">
                    <div class="form-group">
                        <label for="code" class="form-label">Codigo</label>
                        <input type="text" class="form-control" id="code">
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </div>
                </form>
                <div class="alert alert-danger mt-4 d-none" id="error-message"></div>
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.7/axios.min.js"></script>

    <script>
        document.getElementById('second-factor-form').onsubmit = (e) => {

            e.preventDefault();

            const code = document.getElementById('code').value;
            const errorMessage = document.getElementById('error-message')

            errorMessage.classList.add('d-none');

            if (!code) {
                return;
            }

            axios.post('api/loginSecondFactor.php', { code: code })
                .then(result => {
                    //redireccionar al panel
                    window.location = 'panel.php';
                })
                .catch(error => {
                    errorMessage.innerText = error.response.data;
                    errorMessage.classList.remove('d-none');
                })
        }
    </script>

</body>

</html>