<?php 

// Appel de mon fichier de connexion à la BDD
require_once "inc/init.php";

// Vérification de la validation du formulaire
if ( !empty($_POST) ) {
    
    // Echappement des caractères
    dataEscape();

    // Vérification des données à l'intèrieur des champs
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

    // Si je n'ai aucun message d'erreur je fais l'ajout
    if (empty($errorMessage)) {
        // Insertion du commentaire
        // Le faite de passer les données dans ma fonction, me permet de pouvoir l'utiliser à d'autre endroit dans mon code. Je ne serais plus obligé d'attendre la validation d'un formulaire.
        $success = addComment($bdd, $_POST);

        if ($success) {
            $successMessage .= "Votre commentaire à bien été enregistré <br>";
        } else {
            $errorMessage .= "Erreur lors de l'enregistrement <br>";
        }
    }
}

// Appel du header de mon site
$title = "Ajout";
require_once RACINE_SITE . "inc/header.php"; ?>

<!-- CODE SPECIFIQUE A LA PAGE -->
    <h1 class="text-center">Ajout d'un commentaire</h1>

    <!-- Affichage des messages -->
    <?php require_once RACINE_SITE . "inc/messages.php" ?>

    <!-- Formulaire d'ajout -->
    <form class="col-md-6 mx-auto" action="commentaire.php" method="POST">
        <label class="form-label" for="pseudo">Pseudo</label>
        <input class="form-control" type="text" name="pseudo" id="pseudo">

        <label class="form-label" for="commentaire">Commentaire</label>
        <textarea class="form-control" name="commentaire" id="commentaire" cols="30" rows="5"></textarea>

        <label class="form-label" for="note">Note</label>
        <select class="form-select" name="note" id="note">
            <option disabled selected>Sélectionner une note</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>

        <button class="d-block mx-auto btn btn-success my-3">Envoyer</button>
    </form>

<!--  -->

<?php // Appel du footer de mon site
require_once RACINE_SITE . "inc/footer.php";