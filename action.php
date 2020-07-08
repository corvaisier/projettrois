<?php
// connexion à la base de donnée avec prévention des bugs
try {
    $bdd = new PDO('mysql:host=localhost;dbname=projettrois;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_POST['password']) and isset($_POST['username'])) {
    $username = htmlspecialchars($_POST['username']);

    // Hachage du mot de passe et récupération des données du formulaire
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    var_dump($username);
    var_dump($password);

    // Insertion
    // $req = $bdd->prepare('INSERT INTO "utilisateur" ("nom", "prenom", "username", "password", "question", "reponse") 
    // VALUES (:nom, :prenom, :username, :password, :question, :reponse)');
    // var_dump($req->execute(array($username, $password)));

    $req = $bdd->prepare('INSERT INTO utilisateur (prenom, nom, username, password, question, reponse) 
    VALUES (:prenom, :nom, :username, :password, :question, :reponse)');
    var_dump($req->execute(array(
        'prenom' => '',
        'nom' => '',
        'username' => $username,
        'password' => $password,
        'question' => '',
        'reponse' => ''
    )));
}
?>





