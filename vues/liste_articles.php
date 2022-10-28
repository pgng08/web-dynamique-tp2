<h1>Liste de tous les articles</h1>

<?php
if (isset($donnees["messageSucces"]))
    echo "<p><small class='alert'>". $donnees["messageSucces"] . "</small></p>";
?>

<form method="GET" action="index.php">
    Recherche d'article : <input type="text" name="texteRecherche" /><br>
    <input type="hidden" name="commande" value="RechercheArticle" />
    <input type="submit" name="submit" value="Rechercher" />
</form>

<?php

$definirPluriel = mysqli_num_rows($donnees["articles"]);

// "Ternary operator" utilisé pour ajouter un "s" dans le mot en cas de plus que 1 de la variable $definirPluriel
echo "<small>Total d'article" . ($definirPluriel > 1 ? 's' : '') . " dans le site: " . mysqli_num_rows($donnees["articles"]) . "</small>";

// Boucle pour l'affichage de tous les articles du site
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
?>