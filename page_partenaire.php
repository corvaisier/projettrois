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
    $id = $_POST["id_partenaire"];
    $req = $bdd->prepare('SELECT * FROM partenaire WHERE id_partenaire = ?');
    $req->execute(array($id));
    $donnees= $req->fetch();
?>

<section>
<?php 

  echo'
  <div class="article">
    <div class="logo"><img src=' . $donnees['logo'] .'></div>
    <h2 class="titre">' . htmlspecialchars($donnees['nom_acteur']) .'</h2>
    <div class="lien"><div>
    <div class="text">'.$donnees['texte'].'</div>
  </div>
  ';

 

 
?>

</section>

<footer>
<?php
include "include/footer.php"
?>
</footer>
</body>
</html>