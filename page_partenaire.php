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
  <title>page partenaire</title>
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
    <!-- -->
  </section>

  <section class="affichage_comment">

    <!-- formulaire pour poster son commentaire -->
    <div class="header_comment">
      <h3 class="titre_comment">X commentaires</h3>
      <div class="right">
        <form action="comment.php" method="post" class="new_comment">
          <input type="text" name="message" id="message" placeholder="Commentaire" /><br />
          <input type="hidden" value='<?= $donnees["id_partenaire"] ?>' name="id_partenaire" />
          <input type="submit" value="Nouveau commentaire" />
        </form>
        <div class="like">
          <p>

            <?php
            //affichage du nmbr de like
            $like_system = $bdd->prepare('SELECT * FROM likes WHERE id_partenaire = ?');
            $like_system->execute(array($id));
            $like = $like_system -> rowCount();

            $dislike = $bdd->prepare('SELECT * FROM dislike WHERE id_partenaire = ?');
            $dislike->execute(array($id));
            $dislike= $dislike-> rowCount();

              echo '
            <div class="likee">
              <a href="comment.php?a=1&id_partenaire=' . $id . '">like</a>
              ' . $like . '
            </div>
            <div class="dislike">   
              <a href="comment.php?a=2&id_partenaire=' . $id . '">dislike</a>
              ' . $dislike . '
            </div>';
            

            ?>
          </p>

        </div>
      </div>
    </div>

    <?php
    //insertion commentaire dans la bdd
    $comment = $bdd->prepare('SELECT * FROM commentaire WHERE id_partenaire = ?');
    $comment->execute(array($id));
    while ($commentaire = $comment->fetch()) {
      $id_user = $commentaire["id_user"];
      $user = $bdd->prepare('SELECT * FROM utilisateur WHERE id_user = ?');
      $user->execute(array($id_user));
      $user_nom = $user->fetch();
      echo '
        <div class="billet">
        <div class="user">' . $user_nom["nom"] . '</div>
        <div class="user">' . $commentaire["date"] . '</div>
        <div class="commentaire">' . $commentaire['commentaire'] . '</div>
        </div>
        ';
    }
    $comment->closeCursor();
    //$user->closeCursor();
    ?>

  </section>

  <footer>
    <?php
    include "include/footer.php"
    ?>
  </footer>
</body>

</html>