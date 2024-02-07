<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Test Authenticator</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
            </ul>


            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                <?php if ($userController->isUserLoggedIn()) : ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="panel.php"><?= $_SESSION['email'] ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="api/logout.php">Cerrar sesion</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="register.php">Registrarme</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="login.php">Iniciar sesion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>