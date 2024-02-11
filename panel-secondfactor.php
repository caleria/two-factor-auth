<?php
include './templates/header.php';

if (!$userController->isUserLoggedIn()) {
    header('Location: login.php');
}

//segundo factor de autenticacion
$user = $userController->getUser();

$hasTwoFactorActive = true;

if ($user['two_factor_key'] === null) {
    $hasTwoFactorActive = false;

    $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
    $secret = $g->generateSecret();
    $qrcode = \Sonata\GoogleAuthenticator\GoogleQrUrl::generate($user['email'], $secret, 'Pruebas-Auth');
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

    <?php if (!$hasTwoFactorActive) : ?>
        <div class="container mt-5">
            <h5>Activar doble factor de autenticacion</h5>
            <hr>
            <p>1. Para activar el segundo factor de autenticacion, instale Google Authenticator y escanee el codigo QR</p>
            <img src="<?= $qrcode ?>" alt="Codigo QR">

            <p class="mt-4">2. Escriba el codigo generado por Google Authenticator y presione activar doble factor</p>
            <div class="row">
                <div class="col-md-4">
                    <form id="activate-second-factor-form">
                        <div class="form-group">
                            <label for="codigo">Codigo</label>
                            <input type="text" class="form-control" id="codigo">
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Activar doble factor</button>
                        </div>
                    </form>
                    <div class="alert alert-danger mt-4 d-none" id="error-message"></div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="container mt-5">
            <h5>Desactivar doble factor de autenticacion</h5>
            <hr>
            <button type="button" class="btn btn-primary" id="deactivate-second-factor-button">Desactivar doble factor</button>

            <div class="alert alert-danger mt-4 d-none" id="error-message"></div>
        </div>

    <?php endif ?>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.7/axios.min.js"></script>

    <?php if (!$hasTwoFactorActive) : ?>
        <script>
            document.getElementById('activate-second-factor-form').onsubmit = (e) => {

                e.preventDefault();

                const codigo = document.getElementById('codigo').value;
                const secret = '<?= $secret ?>'
                const errorMessage = document.getElementById('error-message')

                errorMessage.classList.add('d-none');

                if (!codigo || !secret) {
                    return;
                }

                axios.post('api/activateSecondFactor.php', {
                        codigo: codigo,
                        secret: secret
                    })
                    .then(result => {
                        //recargar la pagina
                        window.location = 'panel-secondfactor.php';
                    })
                    .catch(error => {
                        errorMessage.innerText = error.response.data;
                        errorMessage.classList.remove('d-none');
                    })
            }
        </script>
    <?php else : ?>
        <script>
            document.getElementById('deactivate-second-factor-button').onclick = (e) => {

                e.preventDefault;

                const errorMessage = document.getElementById('error-message');
                errorMessage.classList.add('d-none');

                axios.post('api/deactivateSecondFactor.php')
                    .then(res => {
                        //recargar la pagina
                        window.location = 'panel-secondfactor.php';
                    })
                    .catch(erro => {
                        errorMessage.innerText = error.response.data;
                        errorMessage.classList.remove('d-none');
                    })
            }
        </script>
    <?php endif ?>

</body>

</html>