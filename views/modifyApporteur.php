<div class="card border-2 py-2 d-flex flex-column justify-content-center align-items-center">
    <div class="p-5">
        <h1 class="text-center"><?=$this->getTitle()?></h1>
        <span class="text-success fw-bold"><?=$msg ?? '' ?></span>
        <form method="POST">
            <!-- CODE D'APPORTEUR-->
            <div class="mt-5">
                <label for="code_apporteur" class="form-label fw-bold">Code d'apporteur <span class="text-danger">*<span></label>
                <input type="text" name="code_apporteur" value="<?=$apporteur->getCode_apporteur() ?? '' ?>" class="form-control" id="code_apporteur" required>
                <span class="text-danger"><?= $errors['code_apporteur'] ?? '' ?></span>
            </div>
            <!-- NOM D'APPORTEUR-->
            <div class="mt-2">
                <label for="nom_apporteur" class="form-label fw-bold">Description d'apporteur<span class="text-danger">*<span></label>
                <input type="text" name="nom_apporteur" value="<?= $apporteur->getNom_apporteur() ?? '' ?>" class="form-control" id="nom_apporteur" required>
                <span class="text-danger"><?= $errors['nom_apporteur'] ?? '' ?></span>
            </div>
            <!-- BOUTON VALIDATION -->
            <button type="submit" class="btn bg-cabp text-white my-4" value="Modifier">Modifier</button>
        </form>
    </div>
</div>