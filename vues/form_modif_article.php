<?php

// Ici la premiere ligne pour prendre idAuteur du article et comparer avec la session d'usager 
$rangeeArticle = mysqli_fetch_assoc($donnees["article"]);

// Si sont pas egales, envoye a la page Index
if ($rangeeArticle["idAuteur"] != $_SESSION["usager"]) {
    header("Location: index.php");
    die();
}

//Condition pour afficher un message si les champs sont vides
if (isset($_REQUEST["submit"]) && (empty($_REQUEST["titre"]) || empty($_REQUEST["texte"]))) {
    $message = "Tous les champs doivent être remplies.";
}
?>

<h1>Formulaire de modification d'un article</h1>

<form method="POST" action="index.php">

    Titre : <br><input type="text" name="titre" maxlength="100" value="<?php echo htmlspecialchars($rangeeArticle["titre"], ENT_QUOTES) ?>"><br>
    Texte : <br><textarea name="texte" id="texte" cols="30" rows="10"><?php echo htmlspecialchars($rangeeArticle["texte"], ENT_QUOTES) ?></textarea><br>

    <input type="hidden" name="idAuteur" value="<?= $rangeeArticle["idAuteur"] ?>" />
    <input type="hidden" name="idArticle" value="<?= $rangeeArticle["id"] ?>" />
    <input type="hidden" name="commande" value="ModifArticle" />
    <input type="submit" name="submit" value="Modifier" />

</form>

<?php
if (isset($message))
    echo "<p><small class='alert'>$message</small></p>";
?>