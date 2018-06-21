<?php require_once('inc/header.admin.inc.php');?>
<?php
$content .= '<a href="?action=affichage">Affichage des produits</a><br>';
$content .= '<a href="?action=ajout">Ajout d\'un produit</a><br><hr>';

//Suppression d'une produit:
if( isset($_GET['action']) && $_GET['action'] == 'suppression'){
  $r = execute_requete("SELECT * FROM produit WHERE id_produit='$_GET[id_produit]'");
  $produit_a_supprimer = $r->fetch(PDO::FETCH_ASSOC);
  $modif = str_replace('http://localhost',$_SERVER['DOCUMENT_ROOT'],$produit_a_supprimer);
    $chemin_Photo_a_Supprimer = $modif['photo'];
    if(!empty($chemin_Photo_a_Supprimer)&&file_exists($chemin_Photo_a_Supprimer)){
      unlink($chemin_Photo_a_Supprimer);
    }
    execute_requete("DELETE FROM produit WHERE id_produit=$_GET[id_produit]");
    header('location:gestion_produit.php?action=affichage');
}

//Enregistrement des produits:
if(!empty($_POST)){
  
  $dateA = date_create_from_format('d/m/Y H',$_POST['date_arrivee']);
  $arrivee =  date_format($dateA, 'Y-m-d H');
  $dateD = date_create_from_format('d/m/Y H',$_POST['date_depart']);
  $depart =  date_format($dateD, 'Y-m-d H');
  
  var_dump($dateA);
  var_dump($arrivee);
  $photo_bdd = '';
  if( isset($_GET['action']) && $_GET['action'] == 'modification'){
    $photo_bdd = $_POST['photo_actuelle'];
  }
  if(!empty($_FILES['photo']['name'])){
    $nom_photo = $_POST['titre'].'_'.$_FILES['photo']['name'];
    $photo_dossier = $_SERVER['DOCUMENT_ROOT']."/lokisalle/photo/$nom_photo";
    $photo_bdd = URL."photo/$nom_photo";
    copy($_FILES['photo']['tmp_name'], $photo_dossier);
  }
  foreach($_POST as $indice => $valeur ){
    $_POST[$indice] = htmlEntities(addSlashes($valeur));
  }
  if( isset($_GET['action']) && $_GET['action'] == 'modification'){
    execute_requete("UPDATE produit SET
      date_arrivee = '$arrivee',
      date_depart = '$depart',
      id_salle = $_POST[id_salle],
      prix = $_POST[prix]
    WHERE id_produit = $_GET[id_produit]");
  }else{
    execute_requete("INSERT INTO produit (
      date_arrivee,
      date_depart,
      id_salle,
      prix
    )VALUES(
      '$arrivee',
      '$depart',
      $_POST[id_salle],
      $_POST[prix]
    )");
    $content .= '<div class="alert alert-success">Le produit a bien été ajouté.</div>';
  }
}

//Affichage des produits:
if( isset($_GET['action']) && $_GET['action'] == 'affichage' ){
  $r = execute_requete("SELECT * FROM produit");
  $content .= '<h2>Affichage des produits</h2>';
  $content .= 'Nombre de produits référencées : '. $r->rowCount() ;
  $content .= '<table border="1" cellpadding="5" style="text-align:center;">';
  $content .= '<tr>';
  for ($i=0; $i < $r->columnCount() ; $i++) {
    $colonne = $r->getColumnMeta($i);
    $content .= "<th>$colonne[name]</th>";
  }
  $content .= '<th colspan="2">Actions</th>';
  $content .= '</tr>';
  while ($ligne = $r->fetch(PDO::FETCH_ASSOC)) {
    $content .= '<tr>';
    foreach ($ligne as $key => $value) {
      if($key == 'photo'){
        $content .= '<td><img src="'.$value.'" width="80" height="80"></td>';
      }else{
        $content .= '<td>'.$value.'</td>';
      }
    }
    $content .= '<td><a href="?action=modification&id_produit='.$ligne['id_produit'].'">modif</a></td>';
    $content .= '<td><a href="?action=suppression&id_produit='.$ligne['id_produit'].'" onClick="return(confirm(\'En êtes vous certain ?\'))">suppr</a></td>';
    $content .= '</tr>';
  }
  $content .= '</table>';
}

//Affichage du formulaire:
if( isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification') ){
  if( isset($_GET['id_produit']) ){
    $r = execute_requete("SELECT * FROM produit WHERE id_produit = $_GET[id_produit]");
    $produit_actuel = $r->fetch(PDO::FETCH_ASSOC);
  }

$date_arrivee = ( isset($produit_actuel['date_arrivee']) )  ? $produit_actuel['date_arrivee'] : '' ;
$date_depart = ( isset($produit_actuel['date_depart']) )  ? $produit_actuel['date_depart'] : '' ;
$capacite = ( isset($produit_actuel['capacite']) )  ? $produit_actuel['capacite'] : '' ;
$id_salle = ( isset($produit_actuel) && $produit_actuel['id_salle'] == '') ? ' selected':'' ;
$tarif = ( isset($produit_actuel['prix']) )  ? $produit_actuel['prix'] : 'Prix en €uros' ;
$prix = '';

$content .='
<form method="post" enctype="multipart/form-data">
  <label for="date_arrivee">Date Arrivée</label><br>
  <input type="text" name="date_arrivee" id="date_arrivee" value="'.$date_arrivee.'" placeholder="00/00/0000 00"><br><br>

  <label for="date_depart">Date Départ</label><br>
  <input type="text" name="date_depart" id="date_depart" value="'.$date_depart.'" placeholder="00/00/0000 00"><br><br>
  
  <label for="id_salle">Salle</label><br>
  <select name="id_salle" id="id_salle">';
    $salle = execute_requete("SELECT * FROM salle");
    while ($ligne = $salle->fetch(PDO::FETCH_ASSOC)){
      $content .= '
      <option value="';$content .= $ligne['id_salle'];$content .= '">'
        .$ligne['titre'].' - '
        .$ligne['capacite'].' Pers. - '
        .$ligne['adresse'].' - '
        .$ligne['ville'].' - '
        .$ligne['cp'].' - '
        .$ligne['pays'].'</option>';
      }
  $content .='
  </select><br><br>
  
  <label for="prix">Tarif</label><br>
  <input type="text" name="prix" id="prix" value="" placeholder="'.$tarif.'">'.$prix.'<br><br>
  
  <input type="submit" value="'.ucfirst($_GET['action']).'">
</form>';
}
?>
<?= $content ?>
<?php require_once('inc/footer.admin.inc.php');?>