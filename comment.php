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
<a href="accueil.php">accueil</a> </br></br>
  <?php


  //checker si l'id utilisateur est présent pour l'id partenaire
  if (isset($_GET['id_partenaire'])) {
    $id_partenaire = $_GET["id_partenaire"];
    $id_user = $_SESSION["id_user"];
    $action = $_GET["a"];
    $like_system = $bdd->prepare('SELECT * FROM dislike ');
    $like_system->execute(array($id_partenaire));
    $check = $like_system->fetch();
    //stockage des variables et debugage
   
    $like_system->closeCursor();

    if ($check["id_user"] == $id_user) {
      echo "Vous avez déjà posté un avis";
      //choisir si l'action rajoutera un like ou un dislike
    } elseif ($action == 2) {
      $like_insert = $bdd->prepare('INSERT INTO dislike (id_user, id_partenaire, likee, dislike) 
      VALUES (:id_user, :id_partenaire, :likee, :dislike)');
      $like_insert->execute(array(
        'id_user' => $id_user,
        'id_partenaire' => $id_partenaire,
        'likee' => 0,
        'dislike' => 1
      ));
      echo "votre dislike a bien été pris en compte ";
    } elseif ($action == 1) {
      $like_insert->execute(array(
        'id_user' => $id_user,
        'id_partenaire' => $id_partenaire,
        'likee' => 1,
        'dislike' => 0
      ));
      echo "votre like a bien été pris en compte ";

      $like_insert->closeCursor();
    }
  }
  ?>

  <?php
  if (isset($_POST['message'])) {
    $commentaire = htmlspecialchars($_POST['message']);
    //Insertion du message
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
</body>

</html>