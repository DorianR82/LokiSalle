<?php require_once('inc/header.inc.php'); ?>
<?php
//================================================================
if(!userConnect()){header('location:connexion.php');exit();}
if(adminConnect()){$statut = '<p><strong>Statut : Administrateur</strong></p>';}
//================================================================
//Affichage des commandes:
  $id = $_SESSION['membre']['id_membre']; // Récupération de l'Identifiant de l'utilisateur.
  
  // requete jointe pour avoir toutes les données des commandes.
  $recap = execute_requete("SELECT * FROM commande
  JOIN produit
    ON commande.id_produit = produit.id_produit 
  JOIN salle
    ON produit.id_salle = salle.id_salle
  WHERE commande.id_membre = $id");


  $content .= '<h2>Récapitulatif de vos commandes</h2>';
  $content .= 'Nombre de vos commandes référencées : <strong>'. $recap->rowCount() .'</strong>';
  $content .= '<table class="table table-dark table-striped text-center">';
  $content .= '<tr>';

  for ($i=0 ; $i<$recap->columnCount() ; $i++){ // Boucle pour générer dynamiquement les entêtes des colonnes .
    $colonne = $recap->getColumnMeta($i);
    // Renomination des entêtes.
    if($colonne['name'] == 'date_arrivee'){
      $content .= "<th>Détails du produit</th>";
    }
    if($colonne['name'] == 'prix'){
      $content .= "<th>$colonne[name]</th>";
    }
    if($colonne['name'] == 'photo'){
      $content .= "<th>$colonne[name]</th>";
    }    
    //$content .= "<th>$colonne[name]</th>";
  }
  $content .= '<th>Actions</th>';
  $content .= '</tr>';

  // Boucle d'affichage d'une commande par ligne.
  while ($ligne = $recap->fetch(PDO::FETCH_ASSOC)) {
    $content .= '<tr>';
      $content .= '<td>' .$ligne['adresse'].' '.$ligne['ville'].' '.$ligne['pays']. '<br> Disponible du ' .$ligne['date_arrivee']. ' au ' .$ligne['date_depart'] . '<br> Capacité max : ' . $ligne['capacite'].'</td>';
      $content .= '<td>' . $ligne['prix'] . '</td>';
      $content .= '<td><img src="' . $ligne['photo'] . '" width="80" height="80"></td>';
      $content .= '<td><a href="?action=suppression&id_commande='.$ligne['id_commande'].'"  onClick="return( confirm(\'En êtes vous scertain?\') )" ><i class="fas fa-trash-alt"></i></a></td>';
    $content .= '</tr>';
  }
  $content .= '</table>';
//================================================================?>
<h1>Bonjour <?=$_SESSION['membre']['pseudo']?></h1>
<p>Voici vos informations :</p>
<?= $statut ?>
<p>Nom : <?=$_SESSION['membre']['nom']?></p>
<p>Prénom : <?=$_SESSION['membre']['prenom']?></p>
<p>Email : <?=$_SESSION['membre']['email']?></p>
<p>Inscript depuis : <?=$_SESSION['membre']['date_inscription']?><p>
<?= $content ?>

<?php require_once('inc/footer.inc.php'); ?>