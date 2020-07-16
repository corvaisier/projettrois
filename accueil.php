<?php
session_start();
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
    <div class="header">
      <div class="logo">futur logo d'entreprise</div>
      <div class="utilisateur">
        <img src="ressource/user_icon.png" alt="user icon">
        <div class="username"><?php echo $_SESSION['username']; ?></div>
      </div>
    </div>
  </header>
  <section class="presentation">
    <h1>texte de présentation gbaf</h1>
    <p>futur logo</p>
  </section>
  <section class="acteurs">
    <h2>text acteur et partenaire</h2>
    <div class="conteneur">
      <div class="element">

      </div>
    </div>
  </section>

  <a href="admin.php">administration</a>
  <a href="deco.php">se déconnecter</a>


</body>