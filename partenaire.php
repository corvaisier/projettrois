<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="GBAF extranet banquaire">
    <link rel="stylesheet" href="css\style.css">
</head>

<form method="post" class="form">
    <p>
        <input type="text" name="logo" placeholder="logo">
        <input type="text" name="nom_acteur" placeholder="nom_acteur" />
        <input type="text" name="texte" placeholder="texte" />
        <input type="submit" value="Valider" name="submit" />
    </p>
</form>


<?php
// connexion à la base de donnée avec prévention des bugs
try {
    $bdd = new PDO('mysql:host=localhost;dbname=projettrois;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


if (isset($_POST['logo']) and isset($_POST['nom_acteur']) and isset($_POST['texte'])) {
    //Insertion
    $req = $bdd->prepare('INSERT INTO partenaire (logo, nom_acteur, texte) 
VALUES (:logo, :nom_acteur, :texte)');

    $req->bindParam(':logo', $logo);
    $req->bindParam(':nom_acteur', $nom_acteur);
    $req->bindParam(':texte', $texte);
    $logo = $_POST['logo'];
    $nom_acteur = $_POST['nom_acteur'];
    $texte = $_POST['texte'];
    $req->execute();
    header("Location: partenaire.php");
} else {
    return "erreur";
}
?>

</html>