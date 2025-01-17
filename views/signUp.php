<form class="row" method="POST" novalidate>
    <div class="mb-3">
        <!-- Matricule -->
        <label for="matricule" class="form-label">Matricule</label>
        <input type="text" class="form-control" id="matricule" name="matricule" value="<?= $matricule ?? '' ?>" required pattern='<?=REGEXMATRICULE?>' placeholder="Veuillez saisir votre numéro de matricule.">
        <span class="text-danger"><?= $errors['matricule'] ?? '' ?></span>
    </div>
    <div class="mb-3">
        <!-- Mot de passe -->
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" value="<?= $password ?? '' ?>" placeholder="Veuillez saisir votre mot de passe." required>
        <span class="text-danger"><?= $errors['password'] ?? '' ?></span>
        <span class="text-danger"><?=$this->errormsg ?? ''?></span>
    </div >
    <div><button type="submit" class="my-4 btn btn-secondary text-white w-100">Se connecter</button></div>
</form>