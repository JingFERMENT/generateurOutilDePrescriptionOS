<!-- FORMULAIRE POUR LE CONSEILLER COMMERCIAL -->
    <form class="row" method="POST">
        <h1 class="text-center"><?=$this->getTitle()?></h1>
        <span class="fw-bold text-success text-center"><?=$msg ?? ''?></span>
        <div class="my-3">
            <!-- ID part-->
            <label for="id_part" class="form-label title">Identifiant partenaire<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="id_part" name="id_part" value="<?= $id_part ?? '' ?>" pattern="<?= REGEXIDPART ?>" placeholder="L'identifiant partenaire comporte 14 chiffres" required>
            <span class="text-danger"><?= $errors['id_part'] ?? '' ?></span>
        </div>
        
        <div class="mb-3">
            <!-- Nom de campagne-->
            <label for="id_campagne" class="form-label title">Motif de la demande<span class="text-danger">*<span></label>
            <select name="id_campagne" id="id_campagne" class="form-select" data-id-campagne="<?= $id_campagne ?? '' ?>">
                <option selected disabled>-- Veuillez sélectionner votre motif de la demande --</option>
                <?php
                    foreach ($this->campagnes as $campagne) {
                    $isSelected = (isset($id_campagne) && $id_campagne == $campagne->id_campagne) ? 'selected' : '';
                    
                    echo "<option value=\"$campagne->id_campagne\" $isSelected>$campagne->nom_campagne</option>";
                }?>
            </select>
            <span class="text-danger"><?= $errors['nom_campagne'] ?? '' ?></span>
        </div>
        
        <div id="formApporteurName" data-last-selecteur-apporteur="<?= $code_apporteur ?? '' ?>">
            <!-- CODE d'apporteur -->
            <label for="code_apporteur" class="form-label title">Nom d'apporteur<span class="text-danger">*<span></label>
            <select name="code_apporteur" id="code_apporteur" class="form-select">
                <!-- dynamic loading -->         
            </select>
        </div>
        
        <span id="errorCodeApporteur" class="mb-3 text-danger"><?= $errors['code_apporteur'] ?? '' ?></span>
        
        <div class="mb-3">
            <!-- Informations complémentaires-->
            <label for="infos" class="form-label title">Informations complémentaires</label>
            <textarea type="infos" class="form-control" id="infos" rows="3" maxlength="1000" placeholder="Vous pouvez ajouter vos informations complémentaires ici." name="infos" value="<?= $infos ?? '' ?>"></textarea>
            <span class="text-danger"><?= $errors['infos'] ?? '' ?></span>
        </div>
        <div><button type="submit" class="btn bg-cabp text-white w-100">Envoyer</button></div>
        <small class="text-danger fw-lighter fst-italic"><span class="text-danger">*</span> champs obligatoires</small>
    </form>