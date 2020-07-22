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
    <title>commentaires</title>
    <link rel="stylesheet" href="css\comment.css">
</head>

<body class="body">

    <?php



    if (isset($_POST['message'])) {
        $commentaire = htmlspecialchars($_POST['message']);
        //Insertion
        $req = $bdd->prepare('INSERT INTO commentaire (id_user, id_partenaire, date, commentaire) 
        VALUES (:id_user, :id_partenaire, NOW(), :commentaire)');
        $req->execute(array(
          'id_user' => $_SESSION['id_user'],
          'id_partenaire' => $_POST["id_partenaire"],
          'commentaire' => $_POST['message']
        ));
        echo "votre commentaire a bien été posté";
        
      } else {
        return "erreur";
        $req->closeCursor();
      }
    ?>






    <a href="accueil.php">accueil</a>
</body>

</html>