                </div>
                </div>
                </div>
                </main>
                <?php if (isset($_SESSION['userRole']))  {?>
                <footer class="container-fluid bg-cabp p-3 fixed-bottom" data-bs-theme="dark">
                    <div class="text-center text-white">Générateur outil de prescription - © <?=date('Y')?></div>
                </footer>
                <?php } ?>
                </body>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
                <?php if (isset($title) && $title === 'Liste des codes campagnes') { ?>
                    <script src="/public/assets/js/campagne.js"></script>
                <?php } ?>
                <?php if (isset($title) && $title === 'Liste des codes des apporteurs') { ?>
                    <script src="/public/assets/js/apporteur.js"></script>
                <?php } ?>
                <?php if (isset($modifyCampagneController) || isset($addCampagneController) ) { ?>
                    <script src="/public/assets/js/multi-input.js"></script>
                    <script src="/public/assets/js/input-apporteur.js"></script>
                <?php } ?>
                <?php if(isset($formController)){?>
                    <script src="/public/assets/js/form.js"></script>
                <?php } ?>
                </html>