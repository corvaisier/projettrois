<?php
session_start();
?>
<!DOCTYPE html>

<html>

<head>
    <title>GBAF</title>
    <meta name="description" content="GBAF extranet banquaire">
    <meta charset="utf-8">
    <link rel="stylesheet" href="css\style.css">
</head>

<body class="test">
    <div class="title">
        <img src="ressource\gbaf.png">
    </div>
    <section>
        <form method="post" class="form">
            <p>
                <input type="text" name="username" placeholder="username">
                <input type="password" name="password" placeholder="password" />
                <input type="submit" value="Valider" name="submit" />
            </p>
        </form>
    </section>

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
    while ($resultat = $req->fetch()) {

        if (isset($_POST['submit'])) {
            $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);
            //vérification des mots de passes et usernames
            if ($isPasswordCorrect and $_POST['username'] == $resultat['username']) {
                // récupération des éléments de session 
                $_SESSION['username'] = $resultat['username'];
                $_SESSION['nom'] = $resultat['nom'];
                $_SESSION['prenom'] = $resultat['prenom'];
                $_SESSION['id_user'] = $resultat['id_user'];

                // vérification de première connexion, si profil pas rempli redirection vers page de profil
                if (empty($_SESSION['nom'])) {
                    header('Location:profile.php');
                    exit();
                } elseif (!empty($_SESSION['nom'])) {
                    // direction vers la page d'accueil pour les personnes ayant un profil complété
                    header('Location:accueil.php');
                    exit();
                }
            }
        }
    }
    $req->closeCursor();
    ?>
    <!-- bloc de récupération de mot de passe -->
    <form method="post" class="mdp">
        <input type="submit" value="password oublié" name="pass">
    </form>


    <section>
        <?php
        if (isset($_POST['pass'])) {
            echo '<form method="post" class="mdp">
                    <input type="text" name="user" placeholder="username?">
                    <input type="submit" name="re_username">
                  </form>';
        }

        if (isset($_POST['user'])) {
            $user = htmlspecialchars($_POST['user']);
            $req = $bdd->prepare('SELECT * FROM utilisateur WHERE username = ?');
            $req->execute(array($user));
            $donnees = $req->fetch();
            if ($req->rowCount() == 1) {
                echo "<p class='mdp'>" . $donnees['question'] . "? </p>";
                echo '<form method="post" class="mdp">
                    <input type="text" name="reponse" placeholder="réponse?">
                    <input type="submit" name="rep">
                  </form>';
            } else {
                echo "<p class='mdp'>username faux</p>";
            }
        }
        $req->closeCursor();
        if (isset($_POST['reponse'])) {
            $reponse = htmlspecialchars($_POST['reponse']);
            $rep = $bdd->prepare('SELECT * FROM utilisateur WHERE reponse = ? ');
            $rep->execute(array($reponse));
            $_SESSION['reponse'] = $reponse;
            if ($rep->rowCount() == 1) {
                echo "<p class='mdp'>entrez votre nouveau mot de passe</p>";
                echo '<form method="post" class="mdp">
                <input type="text" name="password" placeholder="nouveau mot de passe?">
                <input type="submit" name="mdp">
              </form>';
            } else {
                echo "<p class='mdp'>reponse fausse</p>";
            }
        }
        //insertion nouveau password
        if (isset($_POST['mdp'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $info = $bdd->prepare('UPDATE utilisateur 
        SET password = :password
        WHERE reponse = :reponse');
            $info->execute(array(
                'password' => $password,
                'reponse' => $_SESSION['reponse']
            ));
            echo "<p class='mdp'>mot de passe changé</p>";
        }
        ?>

    </section>

</body>

</html>