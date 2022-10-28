<?php
session_start();

if (isset($_REQUEST["commande"])) {
    $commande = $_REQUEST["commande"];
} else {
    $commande = "Accueil";
}

require_once("modele.php");

switch ($commande) {

        // Commande pour afficher la premier page du site
    case "Accueil":
        $donnees["titre"] = "Page d'accueil";
        require_once("vues/header.php");
        require("vues/accueil.html");
        require_once("vues/footer.php");
        break;

        // Commande pour afficher le formulaire de login d'usager
    case "FormLogin":
        $donnees["titre"] = "Page de Login";
        require_once("vues/header.php");
        require("vues/form_login.php");
        require_once("vues/footer.php");
        break;

        // Commande pour deconnecter l'usager
    case "Logout":
        require("vues/logout.php");
        break;

        // Commande pour l'affichage des tous articles
    case "ListeTousArticles":
        $donnees["titre"] = "Liste des articles";
        $donnees["articles"] = obtenir_articles();
        require_once("vues/header.php");
        require("vues/liste_articles.php");
        require_once("vues/footer.php");
        break;

        // Commande pour la page du formulaire d'ajout d'un article
    case "FormAjouterArticle":
        $donnees["titre"] = "Formulaire Ajouter un article";
        require_once("vues/header.php");
        require("vues/form_ajout_article.php");
        require_once("vues/footer.php");
        break;

        // Commande pour l'usager connecté ajouter un article
    case "AjouterArticle":

        if (isset($_SESSION["usager"]) && (!empty($_REQUEST["titre"]) && !empty($_REQUEST["texte"]))) {
            $idA = $_SESSION["usager"];
            $ti = $_REQUEST["titre"];
            $te = $_REQUEST["texte"];

            ajouter_article($idA, $ti, $te);
            header("Location: index.php?commande=ListeTousArticles");
        } else {
            $ti = $_REQUEST["titre"];
            $te = $_REQUEST["texte"];

            require_once("vues/header.php");
            require_once("vues/form_ajout_article.php");
            require_once("vues/footer.php");
        }

        break;

        // Commande pour l'usager connecté supprimer un article
    case "SupprimerArticle":

        if (isset($_SESSION["usager"])) {

            $idAr = $_REQUEST["idArticle"];

            // Verifier si l'usager est l'auteur du article à supprimer
            if (verifierAuteurArticle($idAr, $_SESSION["usager"])) {
                supprimer_article($idAr);
                header("Location: index.php?commande=ListeTousArticles");
            } else {
                header("Location: index.php?commande=ListeTousArticles");
            }
        } else {
            require("index.php");
        }
        break;

        // Commande pour affichage du formulaire de modification d'un article
    case "FormulaireModifArticle":

        if ((isset($_SESSION["usager"]) && isset($_REQUEST["idArticle"]) && is_numeric($_REQUEST["idArticle"])) && ($_SESSION["usager"] == $_REQUEST["idAuteur"])) {
            $article = obtenir_article_id($_REQUEST["idArticle"]);

            if ($article !== false) {
                $donnees["titre"] = "Formulaire de modification d'un article";
                $donnees["article"] = $article;

                require_once("vues/header.php");
                require_once("vues/form_modif_article.php");
                require_once("vues/footer.php");
            }
        } else {
            header("Location: index.php");
        }
        break;

        // Commande pour modifier l'article apres l'usager soumis le formulaire
    case "ModifArticle":
        if (($_SESSION["usager"] == $_REQUEST["idAuteur"]) && (!empty($_REQUEST["titre"]) && !empty($_REQUEST["texte"]) && !empty($_REQUEST["idArticle"]))) {
            if (ValideArticle($_REQUEST["titre"], $_REQUEST["texte"], $_REQUEST["idArticle"])) {

                $modification = modif_article($_REQUEST["titre"], $_REQUEST["texte"], $_REQUEST["idArticle"]);
                if ($modification) {
                    $donnees["messageSucces"] = "Modification fait avec succes!";
                    $donnees["titre"] = "Liste des articles";
                    $donnees["articles"] = obtenir_articles();

                    require_once("vues/header.php");
                    require("vues/liste_articles.php");
                    require_once("vues/footer.php");
                }
            } else {
                header("Location: index.php?commande=ListeTousArticles");
            }
        } else if (($_SESSION["usager"] == $_REQUEST["idAuteur"]) && (empty($_REQUEST["titre"]) || empty($_REQUEST["texte"]))) {

            $article = obtenir_article_id($_REQUEST["idArticle"]);

            $donnees["titre"] = "Formulaire de modification d'un article";
            $donnees["article"] = $article;
            require_once("vues/header.php");
            require_once("vues/form_modif_article.php");
            require_once("vues/footer.php");
        } else {
            header("Location: index.php");
        }
        break;

        // Commande pour la page de recherche des articles
    case "RechercheArticle":
        $donnees["titre"] = "Formulaire de recherche d'Article";
        require_once("vues/header.php");
        require_once("vues/form_recherche_article.php");

        if (isset($_REQUEST["texteRecherche"]) && !empty($_REQUEST["texteRecherche"])) {
            // Faire la recherche 
            $donnees["articles"] = recherche_article($_REQUEST["texteRecherche"]);

            // Afficher les résultats de la recherche
            require("vues/resultats_recherche.php");
        }
        require_once("vues/footer.php");
        break;
    default:
        header("Location: index.php");
        die();
}

function ValideArticle($ti, $te, $idAr)
{
    $valide = false;
    $t1 = trim($ti);
    $t2 = trim($te);
    $iA = trim($idAr);

    if ($t1 != "" && $t2 != "" && is_numeric($iA)) {
        $valide = true;
    } else {
        header("Location: index.php");
        die();
    }

    return $valide;
}
