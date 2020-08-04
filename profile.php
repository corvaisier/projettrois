<?php
session_start();
try {
    $bdd = new PDO('mysql:host=localhost;dbname=projettrois;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <header>

    </header>

    <h3 class="titre">Veuillez compléter votre profil</h3>
    <form method="post">
        <input type="text" name="nom" placeholder="Veuillez renseigner votre nom" />
        <input type="text" name="prenom" placeholder="Veuillez renseigner votre prenom" />
        <p>Pour plus de sécurité, pour récupérer votre mot de passe veuillez renseigner une question secrète</p>
        <input type="text" name="question" placeholder="Question secrète" />
        <input type="text" name="reponse" placeholder="Réponse" />
        <input type="submit" name="sub">
    </form>
    <footer>

        <?php
        var_dump($_SESSION['prenom']);
        $username = $_SESSION['username'];
        //insertion du reste du profil
        if (isset($_POST['sub'])) {
            if (isset($_POST['nom']) and isset($_POST['prenom']) and isset($_POST['question']) and isset($_POST["reponse"])) {
                //Insertion
                $info = $bdd->prepare('UPDATE utilisateur 
                SET prenom = :prenom, nom = :nom, question = :question, reponse = :reponse
                WHERE username = :username');
               $info->execute(array(
                   'prenom' => $_POST['prenom'],
                   'nom' => $_POST['nom'],
                   'question' => $_POST['question'],
                   'reponse' => $_POST['reponse'],
                   'username' => $username
               ));
           
              echo "Votre profil a bien été complété
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