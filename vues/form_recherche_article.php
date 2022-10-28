<?php
// Condition pour afficher un message si le champ de recherche est vide
if (isset($_REQUEST["submit"]) && empty($_REQUEST["texteRecherche"])) {
    $message = "Le champ de recherche est vide.";
}
?>

<h1>Formulaire de recherche d'Article</h1>

<form method="GET" action="index.php">
    Recherche d'article : <input type="text" name="texteRecherche" /><br>
    <input type="hidden" name="commande" value="RechercheArticle" />
    <input type="submit" name="submit" value="Rechercher" />
</form>

<?php
if (isset($message))
    echo "<p><small class='alert'>$message</small></p>";
?>