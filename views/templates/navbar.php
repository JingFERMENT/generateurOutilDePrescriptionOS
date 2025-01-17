<?php if (isset($_SESSION['userRole'])) { ?>
    <nav class="navbar navbar-expand-lg bg-cabp" data-bs-theme="dark">
        <div class="container-fluid">
            <div class="p-2">
                <img id="img-form" src="/public/assets/img/logo_ca_white.png" alt="Logo du CABP">
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link active" href="form">Formulaire</a>
                    </li>
                    <?php if (isset($_SESSION['userRole']) && ($_SESSION['userRole'] === 'admin')) { ?>
                        <li class="nav-item dropdown ">
                            <a class="nav-link active dropdown-toggle" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dashboard
                            </a>

                            <ul class="dropdown-menu bg-cabp">
                                <li><a class="dropdown-item text-white" href="listCampagne">Code campagne</a></li>
                                <li><a class="dropdown-item text-white" href="listApporteur">Code apporteur</a></li>
                            </ul>
                        <?php } ?>
                        </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <?php if (!empty($_SESSION['username'])) { ?>
                            <a class="nav-link active" href="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Déconnexion</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php } else { ?>
    <nav class="navbar bg-cabp">
        <div class="container-fluid d-flex justify-content-center my-4">
            <img src="/public/assets/img/logo_ca_white.png" alt="Logo du CABP">
            <span class="navbar-brand mb-0 h1 text-white mx-5 projet-name">Générateur outil de prescription</span>
        </div>
    </nav>
<?php } ?>