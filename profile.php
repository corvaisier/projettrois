<?php
session_start();
try {
    $bdd = new PDO('mysql:host=localhost;dbname=projettrois;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

include "include/header.php"

?>
<!DOCTYPE html>
<html>

<head>
    <title>profil</title>
    <meta charset="utf-8">
    <meta name="description" content="GBAF extranet banquaire">
    <link rel="stylesheet" href="css\profil.css">

</head>

<body class="body">

    <section class="form_profil">
        <h3 class="titre">Veuillez compléter votre profil</h3>
        <form method="post">
        <p>Veuillez renseigner votre nom</p>
            <input type="text" name="nom" required/>
            <p>Veuillez renseigner votre prenom</p>
            <input type="text" name="prenom" required/>
            <p>Pour plus de sécurité, pour récupérer votre mot de passe veuillez renseigner une question secrète</p>
            <p>Question secrète</p>
            <input type="text" name="question" required/>
            <p>Réponse</p>
            <input type="text" name="reponse" required/>
            <input type="submit" name="sub">
        </form>
    </section>

    <footer>

        <?php
        $username = $_SESSION['username'];
        //insertion du reste du profil
        if (isset($_POST['sub'])) {
            if (!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['question']) and !empty($_POST["reponse"])) {
                $prenom = htmlspecialchars($_POST['prenom']);
                $nom = htmlspecialchars($_POST['nom']);
                $question = htmlspecialchars($_POST['question']);
                $reponse = htmlspecialchars($_POST['reponse']);

                //Insertion
                $info = $bdd->prepare('UPDATE utilisateur 
                SET prenom = :prenom, nom = :nom, question = :question, reponse = :reponse
                WHERE username = :username');
                $info->execute(array(
                    'prenom' => $prenom,
                    'nom' => $nom,
                    'question' => $question,
                    'reponse' => $reponse,
                    'username' => $username
                ));

                echo "Votre profil a bien été complété et sera pris en compte à la prochaine connexion
              <a href='accueil.php'>Accueil</a>";
            } else {
                echo "veuillez remplir tous les champs";
            }
        }
        ?>

        <?php
        include "include/footer.php"
        ?>
    </footer>

</body>

</html>