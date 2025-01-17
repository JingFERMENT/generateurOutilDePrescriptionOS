<div class="card border-2 py-2 d-flex flex-column justify-content-center align-items-center"> 
        <h1 class="text-center"><?=$this->getTitle()?></h1>
        <form method="POST" id="updatedForm">
            <!-- CODE DE CAMPAGNE-->
            <div class="mt-5">
                <label for="code_campagne" class="form-label fw-bold">Code de campagne <span class="text-danger">*<span></label>
                <input type="text" name="code_campagne" value="<?= $campagne->getCode_campagne() ?? '' ?>" class="form-control" id="code_campagne" required>
                <span class="text-danger"><?= $errors['code_campagne'] ?? '' ?></span>
            </div>
            <!-- NOM DE CAMPAGNE-->
            <div class="mt-2">
            <label for="nom_campagne" class="form-label fw-bold">Description de campagne<small class="text-secondary fst-italic fw-light"> (destinée aux commerciaux) </small><span class="text-danger">*<span></label>
                <input type="text" name="nom_campagne" value="<?= $campagne->getNom_campagne() ?? '' ?>" class="form-control" id="nom_campagne" required>
                <span class="text-danger"><?= $errors['nom_campagne'] ?? '' ?></span>
            </div>
            <!-- CODE D'APPORTEUR-->
            <div class="mt-2">
                <label for="code_apporteur mb-0" class="form-label fw-bold">Code d'apporteurs</label>
                <small class="text-secondary fst-italic fw-light">(Cliquez droit pour choisir les options)</small>
                <multi-input>
                    <!-- user selection inputs-->
                    <input list="apporteur-list">
                    
                    <!-- Prefilled inputs -->
                    <?php foreach ($apporteursByCodeCampagne as $apporteurByCodeCampagne) { ?>
                        <input type="text" name="prefilledApporteurs[]" class="pre-rempli hidden" value="<?=$apporteurByCodeCampagne?>">
                    <?php } ?>

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
            <button type="submit" class="btn bg-cabp text-white my-4" id="modifier" value="Modifer">Modifier</button>
        </form>
</div>