<?php

  ////////////////////////////////////////////////////////////
 // Enregistrement des commandes par le bouton reservation //
////////////////////////////////////////////////////////////

if($_POST){

  if(isset ($_POST['reservation'])){
    execute_requete("UPDATE produit SET etat = 'reservation' WHERE id_produit = $_POST[produitID]");
    execute_requete(
      "INSERT INTO commande (
        id_membre,
        id_produit,
        date_enregistrement
      ) VALUES (
        $_POST[membreID],
        $_POST[produitID],
        '$enregistrement'
      )");
}

header('location:profil.php');
exit();

?>