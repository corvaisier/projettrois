<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
</head>

<?php
// connexion à la base de donnée avec prévention des bugs
try {
    $bdd = new PDO('mysql:host=localhost;dbname=projettrois;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>
<form action="" method="post">
        <input type="text" name="message" id="message" placeholder="Commentaire" /><br />
        <input type="submit" value="Envoyer" />
</form>

<?php

if (isset($_POST['message'])) {
    $commentaire = htmlspecialchars($_POST['message']);


    //Insertion
    $req = $bdd->prepare('INSERT INTO commentaire (id_user, id_partenaire, commentaire) 
    VALUES (:id_user, :id_partenaire, :commentaire)');
    $req->execute(array(
        'id_user' => '',
        'id_partenaire' => '',
        'commentaire' => $commentaire
       
    ));
    return "le commentaire à été posté";
} else {
    return "erreur";
}


?>

</html>