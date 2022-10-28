<?php
// Condition si n'y a pas d'usager connecté, envoyer a la page Index
if (!isset($_SESSION["usager"])) {
    header("Location: index.php");
    die();
}

//Condition pour afficher un message si les champs sont vides
if (isset($_REQUEST["submit"]) && (empty($_REQUEST["titre"]) || empty($_REQUEST["texte"]))) {
    
    //Récupérer les champs que ont étés remplies pour réinjecter dans les input.
    $titre = $_REQUEST["titre"];
    $texte = $_REQUEST["texte"];

    $message = "Tous les champs doivent être remplies.";
}

?>

<h1>Formulaire d'ajout d'un article</h1>

<form method="POST" action="index.php">
    Titre : <input type="text" name="titre" maxlength="100" value="<?php if (isset($titre)) echo $titre ?>">

    Texte : <textarea name="texte" id="texte" cols="30" rows="10"><?php if (isset($texte)) echo $texte ?></textarea>

    <input type="hidden" name="commande" value="AjouterArticle" />
    <input type="submit" name="submit" value="Ajouter" />
</form>

<?php
if (isset($message))
    echo "<p><small class='alert'>$message</small></p>";
?>