<?php

if (isset($_POST["user"], $_POST["pass"])) {
    $nomUsager = loginEncrypte($_POST["user"], $_POST["pass"]);
    if ($nomUsager) {
        $_SESSION["usager"] = $nomUsager;
        header("Location: index.php");
        die();
    } else {
        $message = "Usager ou mot de passe invalide.";
    }
}
?>

<h1>Formulaire de login</h1>

<form method="POST">
    Nom d'usager : <input type="text" name="user" /><br>
    Mot de passe : <input type="password" name="pass" /><br>
    <input type="submit" name="btnSubmit" value="Login" />
</form>

<br>

<?php
if (isset($message))
    echo "<p><small class='alert'>$message</small></p>";
?>