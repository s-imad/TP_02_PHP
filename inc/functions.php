<?php 

/**
 * Fonction de debug qui me permet d'afficher plus clairement mes données
 */
function debug($variable){
    echo "<pre>";
        print_r($variable);
    echo "</pre>";
}

/**
 * Fonction qui permet d'échapper les caractères spéciaux
 */
function dataEscape($array = [])
{
    
    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
        $_POST[$key] = trim($value);
    }

    foreach ($_GET as $key => $value) {
        $_GET[$key] = htmlspecialchars($value, ENT_QUOTES);
        $_GET[$key] = trim($value);
    }

    foreach ($array as $key => $value) {
        $array[$key] = htmlspecialchars($value, ENT_QUOTES);
        $array[$key] = trim($value);
    }

}

/**
 * Fonction d'ajout d'un commentaire
 */
function addComment($pdoObject, $data){
    $requete = $pdoObject->prepare("INSERT INTO commentaire VALUES (NULL, :pseudo, :commentaire, :note)");
    return $requete->execute([
        'pseudo' => $data['pseudo'],
        'commentaire' => $data['commentaire'],
        'note' => $data['note']
    ]);
}

/**
 * Fonction qui permet de récupérer tous les commentaires
 */
function getAllComments($pdoObject){
    $requete = $pdoObject->query("SELECT * FROM commentaire ORDER BY id_commentaire DESC");
    return $requete->fetchAll();
}

/**
 * Fonction qui permet de supprimer un commentaire via son ID
 * @param PDO $pdoObject Attend la connexion à la BDD
 * @param int $idComment Attend l'id du commentaire à supprimer
 * @return bool TRUE si l'éxecution à fonctionner FALSE si ce n'est pas le cas
 */
function deleteComment(PDO $pdoObject, int $idComment): bool
{
    $requete = $pdoObject->prepare("DELETE FROM commentaire WHERE id_commentaire = :id_commentaire");
    return $requete->execute([
        'id_commentaire' => $idComment
    ]);
}

/**
 * Fonction qui permet la récupération d'un commentaire via son ID
 * @param PDO $pdoObject Attend la connexion à la BDD
 * @param int $idComment Attend l'id du commentaire à récupérer
 * @return array Retourne un commentaire sous forme de tableau associatif
 */
function getCommentById($pdoObject, $idComment){
    $requete = $pdoObject->prepare("SELECT * FROM commentaire WHERE id_commentaire = :id_commentaire");
    $requete->execute(['id_commentaire' => $idComment]);
    return $requete->fetch();
}

/**
 * Fonction de modification d'un commentaire par son ID
 * @param PDO $pdoObject Attend la connexion à la BDD
 * @param int $idComment Attend l'id du commentaire à modifier
 * @param array $data Attend un tableau avec les informations d'un commentaire (pseudo, commentaire, note)
 * @return bool TRUE si la modification a fonctionné FALSE si ce n'est pas le cas
 */
function updateComment($pdoObject, $idComment, $data){
    $requete = $pdoObject->prepare("UPDATE commentaire SET pseudo = :pseudo, commentaire = :commentaire, note = :note WHERE id_commentaire = :id_commentaire");
    return $requete->execute([
        'pseudo' => $data['pseudo'],
        'commentaire' => $data['commentaire'],
        'note' => $data['note'],
        'id_commentaire' => $idComment
    ]);
}