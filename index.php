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

//récupération aux informations servant à se connecter
$req = $bdd->prepare('SELECT * FROM utilisateur ');
$req->execute();
$resultat = $req->fetch();
var_dump($resultat);

//vérification des mots de passes et usernames
if (isset($_POST['submit'])) {
    $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);

    if ($isPasswordCorrect and $_POST['username'] == $resultat['username']) {
        session_start();
        // vérification de première connexion, si profil pas rempli redirection vers page de profil
        if (!empty($_SESSION['nom'])) {
            header("Location: profile.php?username=".$_POST['username']);
             // récupération des éléments de session 
             $_SESSION['username'] = $resultat['username'];
             $_SESSION['nom'] = $resultat['nom'];
             $_SESSION['prenom'] = $resultat['prenom'];
             $_SESSION['id_user'] = $resultat['id_user'];
 
        } else {
            // récupération des éléments de session 
            $_SESSION['username'] = $resultat['username'];
            $_SESSION['nom'] = $resultat['nom'];
            $_SESSION['prenom'] = $resultat['prenom'];
            $_SESSION['id_user'] = $resultat['id_user'];

            // direction vers la page d'accueil pour les personnes ayant un profil complété
            header("Location: accueil.php?id=" . $_SESSION['id_user']. 
            "nom=" . $_SESSION['nom']. 
            "prenom=" . $_SESSION['prenom'].
            "username=" . $_SESSION['username'].
            "id_user=" . $_SESSION['id_user']);

        }
    } else {
        echo 'Mauvais identifiant ou mot de passe !';
    }
}
$req->closeCursor();
?>

</html>