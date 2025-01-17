<div class="card border-2 py-2 d-flex flex-column justify-content-center align-items-center">
    <div class="p-5">
        <h1 class="text-center"><?= $addCampagneController->getTitle() ?></h1>
        <span class="text-success fw-bold"><?= $addCampagneController->getMsg() ?? '' ?></span>
        <form method="POST">
            <!-- CODE DE CAMPAGNE-->
            <div class="mt-5">
                <label for="code_campagne" class="form-label fw-bold">Code de campagne <span class="text-danger">*<span></label>
                <input type="text" name="code_campagne" value="<?= $codeCampagne ?? '' ?>" class="form-control" id="code_campagne" required>
                <span class="text-danger"><?= $addCampagneController->getErrors()['code_campagne'] ?? '' ?></span>
            </div>
            <!-- NOM DE CAMPAGNE-->
            <div class="mt-2">
                <label for="nom_campagne" class="form-label fw-bold">Description de campagne<small class="text-secondary fst-italic fw-light"> (destinée aux commerciaux) </small><span class="text-danger">*<span></label>
                <input type="text" name="nom_campagne" value="<?= $nomCampagne ?? '' ?>" class="form-control" id="nom_campagne" required>
                <span class="text-danger"><?= $addCampagneController->getErrors()['nom_campagne'] ?? '' ?></span>
            </div>
            <!-- CODE D'APPORTEUR-->
            <div class="mt-2">
                <label for="code_apporteur mb-0" class="form-label fw-bold">Code d'apporteurs</label>
                <small class="text-secondary fst-italic fw-light">(Cliquez droit pour choisir les options)</small>
                <multi-input>
                    <!-- user selection inputs-->
                    <input list="apporteur-list">
                    
                    <!-- Suggestions for new inputs -->
                    <datalist id="apporteur-list">
                        <?php foreach ($allApporteurs as $key => $oneApporteur) { ?>
                            <option value="<?= $oneApporteur['code_apporteur'] ?>">
                                <?= $oneApporteur['code_apporteur'] ?>
                            </option>
                        <?php } ?>
                    </datalist>
                </multi-input>
            </div>
            <!-- BOUTON VALIDATION -->
            <button type="submit" class="btn bg-cabp text-white mt-3" value="Ajouter">Ajouter</button>
        </form>
    </div>
</div>