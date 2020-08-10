<?php
  echo" 
  <div class='header'>
     <div class='logo'>
     <img src='ressource\gbaf.png'>
     </div>
     <div class='utilisateur'>
       <img src='ressource/user_icon.png' alt='user icon'>  
       <div class='username'>
       " . $_SESSION['nom']."&". $_SESSION['prenom'] . "
       <br>
       <a href='profile.php'>Profil</a>
       <br>
       <a href='deco.php'>Se déconnecter</a>
       </div>
     </div>
  </div>"
?>
 
