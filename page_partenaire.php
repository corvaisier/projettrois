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
  <title>formation&co</title>
  <link rel="stylesheet" href="css\partenaire.css">
</head>

<body class="body">
  <header>
    <?php
    include "include/header.php"
    ?>
  </header>
  <?php
  //recherche dans la table partenaire, et récupération de l'id du partenaire de la page accueil
  $id = $_POST["id_partenaire"];
  $req = $bdd->prepare('SELECT * FROM partenaire WHERE id_partenaire = ?');
  $req->execute(array($id));
  $donnees = $req->fetch();
  ?>

  <section>
    <?php
    //affichage des éléments de la table partenaire
    echo '
  <div class="article">
    <div class="logo"><img src=' . $donnees['logo'] . '></div>
    <h2 class="titre">' . htmlspecialchars($donnees['nom_acteur']) . '</h2>
    <div class="lien"><div>
    <div class="text">' . $donnees['texte'] . '</div>
  </div>
  ';
    $req->closeCursor();
    ?>
  </section>

  <section class="comment">
    <!-- formulaire pour poster son commentaire -->
    <form action="comment.php" method="post">
      <input type="text" name="message" id="message" placeholder="Commentaire" /><br />
      <input type="hidden" value='<?= $donnees["id_partenaire"] ?>' name="id_partenaire" />
      <input type="submit" value="Envoyer" />
    </form>
  </section>

  <section class="affichage_comment">
    <?php
    $comment = $bdd->prepare('SELECT * FROM commentaire WHERE id_partenaire = ?');
    $comment->execute(array($id));
    while ($commentaire = $comment->fetch()) {
      $id_user = $commentaire["id_user"];
      $user = $bdd->prepare('SELECT * FROM utilisateur WHERE id_user = ?');
      $user->execute(array($id_user));
      $user_nom = $user->fetch();
      echo '
        <div class="user">' . $user_nom["nom"] . '</div>
        <div class="user">' . $commentaire["date"] . '</div>
        <div class="commentaire">' . $commentaire['commentaire'] . '</div>
        ';
    }
    $comment->closeCursor();
    $user->closeCursor();
    ?>

  </section>

  <footer>
    <?php
    include "include/footer.php"
    ?>
  </footer>
</body>

</html>