<?php

if (mysqli_num_rows($donnees["articles"]) > 0) {

    $definirPluriel = mysqli_num_rows($donnees["articles"]);

    // "Ternary operator" utilisé pour ajouter un "s" dans le mot "resultat" en cas de plus que 1 de la variable $definirPluriel
    echo "<small class='alert'>Total de resultat" . ($definirPluriel > 1 ? 's' : '') . " de la recherche '" . htmlspecialchars($_REQUEST["texteRecherche"], ENT_QUOTES) . "' : " . mysqli_num_rows($donnees["articles"]) . "</small>";

    while ($rangee = mysqli_fetch_assoc($donnees["articles"])) {

        echo "<hr><div><h3>" . htmlspecialchars($rangee["titre"], ENT_QUOTES) . "</h3>";
        echo "<p>" . htmlspecialchars($rangee["texte"], ENT_QUOTES) . "</p>";
        echo "<p><small>Auteur: " . htmlspecialchars($rangee["prenom"], ENT_QUOTES) . " " . htmlspecialchars($rangee["nom"], ENT_QUOTES) . "</small></p>";

        // Si un usager est connecté et il est l'auteur de l'article, alors on affiche les boutons de Modifier et Supprimer
        if (isset($_SESSION["usager"]) && $_SESSION["usager"] == $rangee["idAuteur"]) {

            echo "<p><a href='index.php?commande=FormulaireModifArticle&idAuteur=" . $rangee["idAuteur"] . "&idArticle=" . $rangee["id"] . "'>Modifier</a> | ";

            echo "<a href='index.php?commande=SupprimerArticle&idAuteur=" . $rangee["idAuteur"] . "&idArticle=" . $rangee["id"] . "'>Supprimer</a></p>";
        }
        echo "</div>";
    }
} else {
    echo "<p><small class='alert'>Aucun résultat pour la recherche '" . htmlspecialchars($_REQUEST["texteRecherche"], ENT_QUOTES) . "'.</small></p>";
}
