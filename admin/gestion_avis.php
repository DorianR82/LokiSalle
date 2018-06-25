<?php require_once('inc/header.admin.inc.php');?>
<?php
//********************* PHP ***********************//

  ////////////////////////////
 // Modification des avis. //
////////////////////////////

if($_POST){
  execute_requete(" UPDATE avis SET note = '$_POST[note]', commentaire = '$_POST[commentaire]'  WHERE id_avis = '$_GET[id_avis]' ");
  $content .= '<div class="alert alert-success">L\'avis a été mis a jour!</div>';
}

  ////////////////////////////
 // Suppression d'un avis. //
////////////////////////////

if(isset($_GET['action']) && $_GET['action'] == 'suppression' ){execute_requete("DELETE FROM avis WHERE id_avis = $_GET[id_avis]");}

  /////////////////////////////////////////
 // Placeholder pour modification avis. //
/////////////////////////////////////////

if(isset($_GET['action']) && $_GET['action'] == 'modification' ){

  $resavis = execute_requete("SELECT * FROM avis WHERE id_avis = '$_GET[id_avis]'");
  $avis = $resavis->fetch(PDO::FETCH_ASSOC);
  
  $ressalle = execute_requete("SELECT * FROM salle WHERE id_salle IN (SELECT id_salle FROM avis WHERE id_avis = '$_GET[id_avis]') ");
  $salle = $ressalle->fetch(PDO::FETCH_ASSOC);
  
  $resmembre = execute_requete("SELECT * FROM membre WHERE id_membre IN (SELECT id_membre FROM avis WHERE id_avis = '$_GET[id_avis]') ");
  $membre = $resmembre->fetch(PDO::FETCH_ASSOC);
}

//debug($avis);
//debug($salle);
//debug($membre);

$id_avis= ( isset($avis['id_avis']) ) ? $avis['id_avis'] : '';
$id_membre = ( isset($avis['id_membre']) ) ? $avis['id_membre'] : '';
$id_salle = ( isset($avis['id_salle']) ) ? $avis['id_salle'] : '';
$commentaire = ( isset($avis['commentaire']) ) ? $avis['commentaire'] : '';
$note = ( isset($avis['note']) ) ? $avis['note'] : '';
$date_enregistrement = ( isset($avis['date_enregristrement']) ) ? $avis['date_enregristrement'] : '';
$email = ( isset($membre['email']) ) ? $membre['email'] : '';
$titre = ( isset($salle['titre']) ) ? $salle['titre'] : '';

  //////////////////////////////////////////////
 // Affichage du formulaire de modification. //
//////////////////////////////////////////////

$content .= '
<div class="row mt-5">
  <div class="col-md-4">ID membre : '.$id_membre.' - '.$email.'</div>
  <div class="col-md-4">ID salle : '.$id_membre.' - '.$titre.'</div>
  <div class="col-md-4">ID avis : '.$id_avis.'</div>
</div>';

$content .= '
<form method="post">
<div class="form-group mt-5">
  <label for="note">Note</label>
  <select class="form-control" id="note" name="note">    
    <option value="0" ';      
    if($note == 0 )
    $content .= ' selected';
    $content .= '>☆☆☆☆☆</option>
    <option value="1" ';      
    if($note == 1 )
    $content .= ' selected';
    $content .= '>★☆☆☆☆</option>
    <option value="2" ';      
    if($note == 2 )
    $content .= ' selected';
    $content .= '>★★☆☆☆</option>
    <option value="3" ';
    if($note == 3 )
    $content .= ' selected';
    $content .= '>★★★☆☆</option>
    <option value="4" ';
    if($note == 4 )
    $content .= ' selected';
    $content .= '>★★★★☆</option>
    <option value="5" ';
    if($note == 5 )
    $content .= ' selected';
    $content .= '>★★★★★</option>';
  $content .= '
  </select>
</div>
<div class="form-group">
  <label for="commentaire">Commentaire</label>
  <textarea class="form-control" name="commentaire" id="commentaire" placeholder="commentaire">' .$commentaire. '</textarea>
</div>
<div class="form-group">
  <input type="submit">
</div>
</form>';

  /////////////////////////
 // Affichage des avis. //
/////////////////////////

$r = execute_requete(
  'SELECT
    a.id_avis,
    a.id_membre,
    a.commentaire,
    a.note,
    a.date_enregistrement,
    m.email,
    s.id_salle,
    s.titre
  FROM
    avis a,
    membre m,
    salle s
  WHERE
    a.id_membre = m.id_membre
  AND
    a.id_salle = s.id_salle');

$content .= '<h6 class="mt-5 mb-4">Affichage des '. $r->rowCount() .' avis :</h6>';

$content .= '
<table class="table table-dark table-striped text-center">
  <tr>
    <th>id avis</th>
    <th>id membre</th>
    <th>id salle</th>
    <th>commentaire</th>
    <th>note</th>
    <th>date d\'enregistrement</th>
    <th colspan=2>actions</th>
  </tr>';
    
while ($ligne = $r->fetch(PDO::FETCH_ASSOC)) {
  $content .= '<tr>';
    $content .= '<td>'. $ligne['id_avis'] .'</td>';
    $content .= '<td>'. $ligne['id_membre'] .' - '. $ligne['email'] .'</td>';
    $content .= '<td>'. $ligne['id_salle'] .' - '. $ligne['titre'] .'</td>';
    $content .= '<td>'. $ligne['commentaire'] .'</td>';
    $content .= '<td>';

  switch  ($ligne['note']){
    case '0':
      $content .= '☆☆☆☆☆';
    break;
    case '1':
      $content .= '★☆☆☆☆';
    break;
    case '2':
      $content .= '★★☆☆☆';
    break;
    case '3':
      $content .= '★★★☆☆';
    break;
    case '4':
      $content .= '★★★★☆';
    break;
    case '5':
      $content .= '★★★★★';
    break;
  }
    $content .= '</td>';
    $content .= '<td>'. $ligne['date_enregistrement'] .'</td>';
    $content .= '<td><a href="?action=modification&id_avis='. $ligne['id_avis'] .'"><i class="fas fa-pencil-alt"></i></a></td>';
    $content .= '<td><a href="?action=suppression&id_avis='. $ligne['id_avis'] .'"  onClick="return( confirm(\'En êtes vous scertain?\') )" ><i class="fas fa-trash-alt"></i></a></td>
  </tr>';
}
$content .= '</table>';

//********************* FIN PHP ***********************//
?>
      <h3 class="mt-5">GESTION DES AVIS</h3>
      <div class="row mt-3">
        <div class="col-md-12 px-0" style="height:2px; width:100%; border-bottom: 1px solid black;"></div>
      </div>

      <?= $content ?>

<?php require_once('inc/footer.admin.inc.php');?>
