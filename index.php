<!DOCTYPE html>

<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css\style.css">
</head>

<form method="post" class="form">
    <p>
        <input type="text" name="username">
        <input type="password" name="password" />
        <input type="submit" value="Valider" name="submit" />
    </p>
</form>


<?php
// connexion à la base de donnée avec prévention des bugs
try {
    $bdd = new PDO('mysql:host=localhost;dbname=projettrois;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$req = $bdd->prepare('SELECT username, password FROM utilisateur ');
$req->execute();
$resultat = $req->fetch();
var_dump($resultat);
if(isset($_POST['submit'])) {
    $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);

    if ($isPasswordCorrect AND $_POST['username'] == $resultat['username']) {
        session_start();
       
        $_SESSION['username'] = $resultat['username'];
        header("Location: accueil.php?id=".$_SESSION['username']);

    }
    else {
        echo 'Mauvais identifiant ou mot de passe !';
    }

}

   


?>

</html>