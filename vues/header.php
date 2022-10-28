<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $donnees["titre"] ?>
    </title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <nav>
        <a href="index.php?commande=Accueil">Accueil</a>
        <?php
        if (isset($_SESSION["usager"])) {
            echo "<a href='index.php?commande=FormAjouterArticle'>Ajouter un article</a>";
        }
        ?>
        <a href="index.php?commande=ListeTousArticles">Liste des Articles</a>
        <a href="index.php?commande=RechercheArticle">Recherche d'Article</a>
    </nav>

    <div>
        <p>Bonjour
            <?php
            if (isset($_SESSION["usager"])) {
                $donnees["usager"] = infoUsager($_SESSION["usager"]);

                $rangee = mysqli_fetch_assoc($donnees["usager"]);

                $nomUsagerComplet = $rangee["prenom"] . " " . $rangee["nom"];

                echo " 👤 " . htmlspecialchars($nomUsagerComplet, ENT_QUOTES) . ", vous êtes connecté.";
            } else {
                echo "visiteur.";
            }

            if (isset($_SESSION["usager"])) {
                echo "<small> | <a href='index.php?commande=Logout'>Déconnecter ❌</a></small>";
            } else {
                echo "<small> | <a href='index.php?commande=FormLogin'>Connecter 👤</a></small>";
            }


            ?>
        </p>
    </div>