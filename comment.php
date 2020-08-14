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
  <meta name="description" content="GBAF extranet banquaire">
</head>

<body class="body">
  <a href="accueil.php">accueil</a> </br></br>
  <?php


  //checker si l'id utilisateur est présent pour l'id partenaire
  if (isset($_GET['id_partenaire'])) {
    $id_partenaire = $_GET["id_partenaire"];
    $id_user = $_SESSION["id_user"];
    $action = $_GET["a"];

    $dislike = $bdd->prepare('SELECT * FROM dislike WHERE id_partenaire = ?');
    $dislike->execute(array($id_partenaire));

    //choisir si l'action rajoutera un like ou un dislike et si il y a déjà eu un like ou un dislike, supprimer le précédent
    if ($action == 2) {
      if ($dislike->rowCount() == 1) {
        $del = $bdd->prepare('DELETE FROM dislike WHERE id_partenaire = ? AND id_user = ?');
        $del->execute(array($id_partenaire, $id_user));
        echo "nous avons bien retiré votre like";
      } else {
        $like_insert = $bdd->prepare('INSERT INTO dislike (id_user, id_partenaire) 
        VALUES (:id_user, :id_partenaire)');
        $like_insert->execute(array(
          'id_user' => $id_user,
          'id_partenaire' => $id_partenaire,
        ));
        //suppression automatique si le user avait mis un dislike
        $del = $bdd->prepare('DELETE FROM likes WHERE id_partenaire = ? AND id_user = ?');
        $del->execute(array($id_partenaire, $id_user));

        echo "votre dislike a bien été pris en compte ";
      }
    }
    if ($action == 1) {
      $like = $bdd->prepare('SELECT * FROM likes WHERE id_partenaire = ? AND id_user = ?');
      $like->execute(array($id_partenaire, $id_user));

      if ($like->rowCount() == 1) {
        $del = $bdd->prepare('DELETE FROM likes WHERE id_partenaire = ? AND id_user = ?');
        $del->execute(array($id_partenaire, $id_user));
        echo "nous avons bien retiré votre dislike";
      } else {
        $like_insert = $bdd->prepare('INSERT INTO likes (id_user, id_partenaire) 
        VALUES (:id_user, :id_partenaire)');
        $like_insert->execute(array(
          'id_user' => $id_user,
          'id_partenaire' => $id_partenaire,
        ));
        //suppression automatique si le user avait mis un dislike
        $del = $bdd->prepare('DELETE FROM dislike WHERE id_partenaire = ? AND id_user = ?');
        $del->execute(array($id_partenaire, $id_user));
        echo "votre like a bien été pris en compte ";
      }
    }
  }
  ?>

  <?php
  if (isset($_POST['message'])) {
    $commentaire = htmlspecialchars($_POST['message']);
    //modération de commentaire
    //Insertion du message
    $donnees = $bdd->prepare('SELECT * FROM commentaire WHERE id_partenaire = ? AND id_user = ?');
    $donnees->execute(array($_POST['id_partenaire'], $_SESSION['id_user']));

 
    if ($donnees->rowCount() == 1) {
      echo "Vous avez déjà posté un commentaire pour ce partenaire";
    } else {
      $req = $bdd->prepare('INSERT INTO commentaire (id_user, id_partenaire, date, commentaire) 
      VALUES (:id_user, :id_partenaire, NOW(), :commentaire)');
      $req->execute(array(
        'id_user' => $_SESSION['id_user'],
        'id_partenaire' => $_POST["id_partenaire"],
        'commentaire' => $_POST['message']
      ));
      echo "votre commentaire a bien été posté";
    }
  } else {
    return "erreur";
    $req->closeCursor();
  }


  ?>
</body>

</html>