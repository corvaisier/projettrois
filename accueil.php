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
  <title>accueil</title>
  <link rel="stylesheet" href="css\accueil.css">


</head>

<body class="body">

  <header>
    <?php
    include "include/header.php"
    ?>
  </header>
  <section class="presentation">
    <h1>texte de présentation gbaf</h1>
    <p>futur logo</p>
  </section>



  <section class="acteurs">
    <h2>texte acteur et partenaire</h2>
    <div class="conteneur">
      <div class="element">
      </div>

      <?php
      //requête pour obtenir les info de la table partenaire et stockage de l'id du partenaire
      $req = $bdd->query('SELECT id_partenaire, logo, nom_acteur, texte  FROM partenaire');
      $req->execute();
      // Affichage de chaque message 
      ?>
      <div class="article">
        <?php
        while ($donnees = $req->fetch()) {
          echo '<div class="sous_article"><div class="logo"><img src=' . $donnees['logo'] .'>
          </div><div class="titre"> <h3>' . htmlspecialchars($donnees['nom_acteur']) .'</h3>
          </div>' . htmlspecialchars($donnees['texte']).
            '<form method="post" class="form"   action="page_partenaire.php?">
          <input type="hidden" value="' . htmlspecialchars($donnees["id_partenaire"]) . '" name="id_partenaire" class="none"/>
          <input type="submit" value="lire la suite" name="submit"/>

          </form></div>';
        }

        $req->closeCursor();

        ?>
      </div>


    </div>
  </section>

  <a href="admin.php">administration</a>
  <a href="deco.php">se déconnecter</a>


  <footer>

    <?php
    include "include/footer.php"
    ?>
  </footer>

</body>

</html>