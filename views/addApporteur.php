<div class="card border-2 text-center py-2 d-flex flex-column justify-content-center align-items-center">
    <div class="p-5">
        <h1 class="text-center"><?=$addApporteurController->getTitle()?></h1>
        <span class="text-success fw-bold"><?=$addApporteurController->getMsg() ?? '' ?></span>
        <form method="POST">
            <!-- Add "code apporteur" -->
            <div class="mt-5">
                <label for="code_apporteur" class="form-label fw-bold">Code d'apporteur <span class="text-danger">*<span></label>
                <input type="text" name="code_apporteur" value="<?= $codeApporteur ?? '' ?>" class="form-control" id="code_apporteur" required>
                <span class="text-danger"><?=$addApporteurController->getErrors()['code_apporteur'] ?? '' ?></span>
            </div>
            <!-- Add "nom apporteur" -->
            <div class="mt-2">
                <label for="nom_apporteur" class="form-label fw-bold">Description d'apporteur<span class="text-danger">*<span></label>
                <input type="text" name="nom_apporteur" value="<?= $nomApporteur ?? '' ?>" class="form-control" id="name_apporteur" required>
                <span class="text-danger"><?=$addApporteurController->getErrors()['nom_apporteur'] ?? '' ?></span>
            </div>
            <!-- Button "Add" -->
            <button type="submit" class="btn bg-cabp text-white my-4" value="Ajouter">Ajouter</button>
        </form>
    </div>
</div>