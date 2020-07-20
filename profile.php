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
</head>

<body>
    <header>
        <?php
        include "include/header.php"
        ?>
    </header>
    <footer>

        <?php
        include "include/footer.php"
        ?>
    </footer>

</body>

</html>