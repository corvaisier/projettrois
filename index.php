<html>
<a href="mdp.php">form</a>

<form method="post">
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

$req = $bdd->prepare('SELECT username, password FROM utilisateur');
$req->execute();
$resultat = $req->fetch();

$isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);

if (!$resultat)
{
    echo 'Mauvais identifiant ou mot de passe !';
}
else
{
    if ($isPasswordCorrect) {
        session_start();
       
        $_SESSION['username'] = $resultat['username'];
        echo 'Vous êtes connecté !';
    }
    else {
        echo 'Mauvais identifiant ou mot de passe !';
    }
}


?>

</html>