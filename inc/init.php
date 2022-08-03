<?php 

// ####### ETAPE 1 - CONNEXION A LA BDD #######
$sgbd = "mysql";
$host = "localhost";
$dbname = "php_commentaire";
$username = "root";
$mdp = "";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $bdd = new PDO("$sgbd:host=$host;dbname=$dbname", $username, $mdp, $options);
} catch (Exception $e) {
    die("ERREUR CONNEXION BDD : " . $e->getMessage());
}

// ####### ETAPE 2 - DECLARATION DES VARIABLES ET CONSTANTES #######
$errorMessage = "";
$successMessage = "";

define("RACINE_SITE", str_replace("\\", "/", str_replace("inc", "", __DIR__)));
define("URL", "http://" . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], "", RACINE_SITE ));

// ####### ETAPE 3 - APPEL DES FONCTIONS #######
require_once RACINE_SITE . "inc/functions.php";