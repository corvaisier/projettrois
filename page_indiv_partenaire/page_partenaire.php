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
</head>

<body>
<?php 
    $req = $bdd->query('SELECT id_partenaire, logo, nom_acteur, texte  FROM partenaire');
    $req->execute();
  
?>




</body>
</html>