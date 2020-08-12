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
  <title>Contact</title>
  <script src="https://kit.fontawesome.com/7a6b0f9b75.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css\partenaire.css">
</head>

<body class="body">
  <header>
    <?php
    include "include/header.php"
    ?>
  </header>
 <p>Page de contact</p>

  <footer>
    <?php
    include "include/footer.php"
    ?>
  </footer>
</body>

</html>