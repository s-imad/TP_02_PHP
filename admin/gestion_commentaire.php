<?php 

// Appel de mon fichier de connexion à la BDD
require_once "../inc/init.php";

// Gestion de la Suppression
if ( isset($_GET['action']) && $_GET['action'] == "supprimer" ) {
    // Echappement des caractères
    dataEscape();

    // Faire la suppression
    $success = deleteComment($bdd, $_GET['id_commentaire']);

    if ($success) {
        $successMessage .= "Commentaire supprimé <br>";
    } else {
        $errorMessage .= "Erreur lors de la suppression <br>";
    }
    
}

// Gestion de la modification
if ( isset($_GET['action']) && $_GET['action'] == "modifier" ) {
    // Echappement des caractères spéciaux
    dataEscape();

    // Modification du commentaire SI le formulaire a été validé
    if ( !empty($_POST) ) {

        // Vérification des données
            if (empty($_POST['pseudo']) || iconv_strlen($_POST['pseudo']) > 100 ) {
                $errorMessage .= "Merci d'indiquer un pseudo de moins de 100 caractères<br>";
            }
            if (empty($_POST['commentaire'])) {
                $errorMessage .= "Merci de mettre un commentaire <br>";
            }
            $notes = [1,2,3,4,5];
            if (!isset($_POST['note']) || !in_array($_POST['note'], $notes) ) {
                $errorMessage .= "Note non valide";
            }
        //

        $success = updateComment($bdd, $_GET['id_commentaire'], $_POST);
    
        if ($success) {
            $successMessage .= "Commentaire modifié ! <br>";
        } else {
            $errorMessage .= "Erreur lors de la modification <br>";
        }
    }

    // Récupérer le commentaire sélectionné
    $commentaireSelected = getCommentById($bdd, $_GET['id_commentaire']);

}

// Récupération de tous les commentaires
$commentaires = getAllComments($bdd);

// Appel du header de mon site
$title = "Admin";
require_once RACINE_SITE . "inc/header.php"; ?>

<!-- CODE SPECIFIQUE A LA PAGE -->

    <h1 class="text-center mt-4">Gestion des Commentaires</h1>

    <?php require_once RACINE_SITE . "inc/messages.php" ?> 

    <!-- Affichage des commentaires de la BDD -->
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>id_commentaire</th>
                <th>Pseudo</th>
                <th>Commentaire</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Affichage dynamique des données -->
            <?php 
                foreach ($commentaires as $commentaire) {
                    echo "<tr>";
                        foreach ($commentaire as $value) {
                            echo "<td>$value</td>";
                        } ?>
                        
                        <td>
                            <a href="gestion_commentaire.php?action=supprimer&id_commentaire=<?= $commentaire['id_commentaire'] ?>" onclick="return confirm('Etes vous sur de vouloir supprimer ce commentaire ?')">Supprimer</a>
                            <a href="?action=modifier&id_commentaire=<?= $commentaire['id_commentaire'] ?>">Modifier</a>
                        </td>
                    <?php echo "</tr>";   
                }
            ?>

        </tbody>
    </table>

    <!-- Affichage du formulaire de modification du commentaire -->
    <?php if ( isset($_GET['action']) && $_GET['action'] === "modifier" ) { ?>
        <form class="col-md-6 mx-auto" action="" method="POST">

            <label class="form-label" for="pseudo">Pseudo</label>
            <input 
                class="form-control" 
                type="text" 
                name="pseudo" 
                id="pseudo" 
                value="<?= $commentaireSelected['pseudo'] ?? "" ?>"
            >

            <label class="form-label" for="commentaire">Commentaire</label>
            <textarea class="form-control" name="commentaire" id="commentaire" cols="30" rows="5"><?= $commentaireSelected['commentaire'] ?? "" ?></textarea>

            <label class="form-label" for="note">Note</label>
            <select class="form-select" name="note" id="note">
                <option <?= ($commentaireSelected['note'] == 1) ? "selected" : "" ?> value="1">1</option>
                <option <?= ($commentaireSelected['note'] == 2) ? "selected" : "" ?> value="2">2</option>
                <option <?= ($commentaireSelected['note'] == 3) ? "selected" : "" ?> value="3">3</option>
                <option <?= ($commentaireSelected['note'] == 4) ? "selected" : "" ?> value="4">4</option>
                <option <?= ($commentaireSelected['note'] == 5) ? "selected" : "" ?> value="5">5</option>
            </select>

            <button class="btn btn-warning d-block mx-auto my-3">Modifier</button>

        </form> 
    <?php } ?>

<!--  -->

<?php // Appel du footer de mon site
require_once RACINE_SITE . "inc/footer.php";