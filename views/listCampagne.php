<div id="page-content-wrapper" class="mx-auto">
    <div class="card border-2 text-center">
        <div class="p-3">
            <h1><?=$title?></h1>
            <span class="text-success fw-bold"><?=$msg ?? ''?></span>
            <div class="d-flex justify-content-end">
                <a href="addCampagne" class="btn bg-cabp text-white m-4">Ajouter</a>
            </div>
            <!-- LISTE DES CODES CAMPAGNES -->
            <div class="d-flex justify-content-end gap-5">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Code des campagnes</th>
                            <th scope="col">Description des campagnes</th>
                            <th scope="col">Code des apporteurs</th>
                            <th scope="col">Modifier</th>
                            <th scope="col">Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($campagnes as $campagne) {?>
                        <tr>
                            <!-- code campagne -->
                            <th scope="row" class="fw-normal"><?=$campagne->code_campagne?></th>
                            <!-- nom campagne -->
                            <th scope="row" class="fw-normal"><?=$campagne->nom_campagne?></th>
                            <!-- code apporteurs -->
                            <th scope="row" class="fw-normal"><?=implode(', ', $apporteursArrayForEachCampagne[$campagne->id_campagne])?></th>
                            <!-- modifier -->
                            <td>
                                <a class="text-dark" href="modifyCampagne?id=<?=$campagne->id_campagne?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            </td>
                            <!-- Button trigger modal to delete -->
                            <td><a type="button" data-id="<?=$campagne->id_campagne?>" data-bs-toggle="modal" data-bs-target="#deleteModal" class="text-dark modalOpenCodeCampagneDeleteBtn"><i class="fa-solid fa-trash-can"></i></a></td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-danger" id="exampleModalLabel">Supprimer une campagne</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                Pouvez-vous confirmer votre choix ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger deleteCampagneBtn" data-bs-dismiss="modal">Oui</button>
                    <button type="button" data-bs-dismiss="modal" class="btn bg-cabp text-white">Non</button>
                </div>
            </div>
        </div>
    </div>
</div>