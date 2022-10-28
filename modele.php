<?php

// en local mamp

// define("SERVER", "localhost");
// define("USERNAME", "root");
// define("PASSWORD", "root");
// define("DBNAME", "tp2-blog");


// en local xampp

// define("SERVER", "localhost");
// define("USERNAME", "root");
// define("PASSWORD", "");
// define("DBNAME", "tp2-blog");


// webdev

define("SERVER", "localhost");
define("USERNAME", "");
define("PASSWORD", "");
define("DBNAME", "");


function connectDB()
{
    $c = mysqli_connect(SERVER, USERNAME, PASSWORD, DBNAME);

    if (!$c) {
        die("Erreur de connexion. MySQLI : " . mysqli_connect_error());
    }

    mysqli_query($c, "SET NAMES 'utf8'");

    return $c;
}

$connexion = connectDB();


// ---------------------
// Fonctions du Blog:
// ---------------------

// Fonction pour obtenir tous les articles
function obtenir_articles()
{
    global $connexion;
    $requete = "SELECT * FROM articles JOIN usagers ON usagers.username = articles.idAuteur ORDER BY id DESC";
    $resultats = mysqli_query($connexion, $requete);
    return $resultats;
}

// Fonction pour obtenir un article par son ID
function obtenir_article_id($idArticle)
{
    global $connexion;
    $requete = "SELECT * FROM articles WHERE id = $idArticle";
    $resultats = mysqli_query($connexion, $requete);
    return $resultats;
}

// Fonction pour ajouter un article
function ajouter_article($idA, $ti, $te)
{
    global $connexion;
    $requete = "INSERT INTO articles(idAuteur, titre, texte) VALUES (?, ?, ?)";
    $reqPrep = mysqli_prepare($connexion, $requete);

    if ($reqPrep) {
        mysqli_stmt_bind_param($reqPrep, "sss", $idA, $ti, $te);
        return mysqli_stmt_execute($reqPrep);
    } else
        die("Erreur de requête préparée...");
}

// Fonction pour supprimer un article par son ID
function supprimer_article($idAr)
{
    global $connexion;
    $requete = "DELETE FROM articles WHERE id = ?";

    $reqPrep = mysqli_prepare($connexion, $requete);

    if ($reqPrep) {
        mysqli_stmt_bind_param($reqPrep, "i", $idAr);
        return mysqli_stmt_execute($reqPrep);
    } else
        die("Erreur de requête préparée...");
}

// Fonction pour modifier un article
function modif_article($ti, $te, $idAr)
{
    global $connexion;
    $requete = "UPDATE articles SET titre=?, texte=? WHERE id=?";
    $reqPrep = mysqli_prepare($connexion, $requete);

    if ($reqPrep) {
        mysqli_stmt_bind_param($reqPrep, "ssi", $ti, $te, $idAr);
        return mysqli_stmt_execute($reqPrep);
    } else
        die("Erreur de requête préparée...");
}

//Fonction pour faire la recherche des articles dans le titre et texte
function recherche_article($texte)
{
    global $connexion;

    $requete = "SELECT * FROM articles JOIN usagers ON usagers.username = articles.idAuteur WHERE titre LIKE ? OR texte LIKE ?  ORDER BY id DESC";

    $reqPrep = mysqli_prepare($connexion, $requete);

    if ($reqPrep) {
        $texte = "%$texte%";
        mysqli_stmt_bind_param($reqPrep, "ss", $texte, $texte);
        mysqli_stmt_execute($reqPrep);
        $resultats = mysqli_stmt_get_result($reqPrep);
        return $resultats;
    } else
        die("Erreur de requête préparée...");
}


// Fonction pour verifier si l'usager conecté est l'auteur de l'article
function verifierAuteurArticle($idArticle, $sessionUsager)
{
    $article = obtenir_article_id($idArticle);

    while ($rangee = mysqli_fetch_assoc($article)) {
        if ($rangee["idAuteur"] == $sessionUsager) {
            return true;
        } else {
            return false;
        }
    }
}


// Fonction de LOGIN encrypté:
function loginEncrypte($username, $password)
{
    global $connexion;
    $requete = "SELECT * FROM usagers WHERE username=?";

    $reqPrep = mysqli_prepare($connexion, $requete);

    if ($reqPrep) {
        mysqli_stmt_bind_param($reqPrep, "s", $username);
        mysqli_stmt_execute($reqPrep);
        $resultats = mysqli_stmt_get_result($reqPrep);

        if (mysqli_num_rows($resultats) > 0) {
            $rangee = mysqli_fetch_assoc($resultats);
            $motDePasseEncrypte = $rangee["password"];
            if (password_verify($password, $motDePasseEncrypte)) {
                return $rangee["username"];
            } else
                return false;
        } else {
            return false;
        }
    }
}

// Function pour prendre le prenom et nom d'usager pour afficher qui est connecté
function infoUsager($user)
{
    global $connexion;

    $requete = "SELECT prenom, nom FROM usagers WHERE username = '$user'";

    $resultats = mysqli_query($connexion, $requete);

    return $resultats;
}
