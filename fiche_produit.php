<?php require_once('inc/header.inc.php');?>
<?php
//********************* PHP ***********************//

  //////////////////////////////////
 // Récolte des données afficher //
//////////////////////////////////

$resproduit = execute_requete(
  "SELECT *
  FROM produit
  WHERE id_produit = '$_GET[id_produit]' ");

$produit = $resproduit->fetch(PDO::FETCH_ASSOC);

$ressalle = execute_requete(
  "SELECT *
  FROM salle
  WHERE id_salle = (
    SELECT id_salle
    FROM produit
    WHERE id_produit = '$_GET[id_produit]')");
  
$salle = $ressalle->fetch(PDO::FETCH_ASSOC);

  ///////////////////////////////////////////////////////////////////////////
 // Calcul de la moyenne des notes de la salle pour afficher les étoiles. //
///////////////////////////////////////////////////////////////////////////

$resNote = execute_requete(
  "SELECT ROUND(AVG(note))
  AS note
  FROM avis
  WHERE id_salle = $produit[id_salle]
  ");

$moyenne = $resNote->fetch(PDO::FETCH_ASSOC);
$etoilevide = 5 - $moyenne['note'];

  /////////////////////////////////////////////////////////////////////////////
 // Affichage du titre de la salle et de la note illustrée par des étoiles. //
/////////////////////////////////////////////////////////////////////////////

$enTete = $salle['titre'].' ';

for ($i=0; $i < $moyenne['note']; $i++) {
  $enTete .= '★';
}
for ($i=0; $i < $etoilevide; $i++) {
  $enTete .= '☆';
}

//================================================================

  ///////////////////////////////////////
 // Bonton de reservation interactif. //
///////////////////////////////////////

$btn_reza = '';
if(userConnect()){
$btn_reza .= '
<form method="POST" action="fiche_produit.php?id_produit='. $produit['id_produit'] .'">
  <input type="text" name="membreID" value="'. $_SESSION['membre']['id_membre'] .'" style="display:none">
  <input type="text" name="produitID" value="'. $produit['id_produit'] .'" style="display:none">
  <input type="submit" class="btn btn-dark float-right" name="reservation" value="Reserver">
</form>';
}else{
  $btn_reza .= '
<form method="GET" action="connexion.php">
  <input type="submit" class="btn btn-dark float-right" name="reservation" value="Reserver">
</form>';
}              

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
        NOW()
      )");
    header('location:profil.php');
    exit();
  }

   //////////////////////////////////////////////////////////////////////////////////////
  // Boucle pour éviter plusieurs notes sur la même salle de la part d'un même membre. //
 //////////////////////////////////////////////////////////////////////////////////////

  if (isset ($_POST['notation'])){
    
    foreach($_POST as $indice => $valeur){
      $_POST[$indice] = htmlentities( addslashes($valeur) );
    }

    $r_notation = execute_requete("SELECT*FROM avis WHERE id_membre = '$_POST[membreID]'");
    $r_note = $r_notation->fetch(PDO::FETCH_ASSOC);

    if($_POST['salleID'] == $r_note['id_salle']){
      execute_requete(
        "UPDATE avis
        SET
          note = $_POST[note],
          commentaire = $_POST[commentaire],
          date_enregistrement = $enregistrement
        WHERE id_salle = $_POST[salleID]");

    }else{
      execute_requete(
        "INSERT INTO avis (
          id_membre,
          id_salle,
          note,
          commentaire,
          date_enregistrement
        ) VALUES (
          '$_POST[membreID]',
          '$_POST[salleID]',
          '$_POST[note]',
          '$_POST[commentaire]',
          NOW()
        )");
    }
  }
}

//================================================================

////////////////////////////////////////////////////
// Tirage au sort des vignettes de propositions. //
///////////////////////////////////////////////////

$vignettes = '';
$r_vignettes = execute_requete(
  "SELECT
  MIN(id_produit)
  AS MIN,
  MAX(id_produit)
  AS MAX
  FROM produit");
$proposition = $r_vignettes->fetch(PDO::FETCH_ASSOC);

for ($i=0;$i<4;$i++){

  do{

    $id_random = rand($proposition['MIN'], $proposition['MAX']);
    $r_random = execute_requete(
      "SELECT
      produit.id_produit,
      produit.etat,
      salle.photo
      FROM produit
      JOIN salle
      ON produit.id_salle = salle.id_salle
      WHERE produit.id_produit = $id_random");
    $photo = $r_random->fetch(PDO::FETCH_ASSOC);

  }while($produit['id_produit'] == $id_random || $photo['etat'] === 'reservation' || $photo['id_produit'] == NULL);

  $vignettes .= '
  <div class="col-md-3">
    <a href="fiche_produit.php?id_produit='. $photo['id_produit'] .'"><img src="'. $photo['photo'] .'"  alt="" class="w-100"></a>
  </div>';
}

//********************* FIN PHP ***********************//
?>

    <div class="row mt-3">
      <div class="col-md-7 px-0">
        <h2>

        <?= $enTete ?>

        </h2>
      </div>
      <div class="col-md-5 px-0">
      
      <?= $btn_reza ?>
      
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12 px-0" style="height:2px; width:100%; border-bottom: 1px solid black;"></div>
    </div>
    <div class="row mt-4">
      <div class="col-md-7 px-0">
        <img src="<?php echo $salle['photo']; ?>" alt="" class="w-100">
      </div>
      <div class="col-md-5 px-4">
        <div class="description">
          <h5>Description de la Salle</h5>
          <p>
            
          <?php echo $salle['description']?>
            
          </p>
          <h5 class="mt-4">Localisation</h5>
          <iframe src="https://www.google.com/maps?q=<?php echo $salle['adresse'] . ' ' . $salle['cp'] . ' ' . $salle['ville']; ?>&amp;output=embed" height="174" frameborder="0" style="border:1px solid grey; width:100%;"></iframe>
        </div>
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-md-12 px-0">
        <h5>Informations Complémentaires</h5>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 px-0">
        <p><i class="far fa-calendar-alt"></i> Arrivée : <?php echo $produit['date_arrivee'];?></p>
        <p><i class="far fa-calendar-alt"></i> Départ : <?php echo $produit['date_depart'];?></p>
      </div>
      <div class="col-md-4">
        <p><i class="fas fa-users"></i> Capacité : <?php echo $salle['capacite'];?></p>
        <p><i class="fas fa-briefcase"></i> Catégorie : <?php echo $salle['categorie'];?></p>
      </div>
      <div class="col-md-4">
        <p><i class="fas fa-map-marker"></i> <?php echo $salle['adresse']. ', '. $salle['cp'] . ' '. $salle['ville'];?></p>
        <p> <i class="fas fa-coins"></i> Tarif : <?php echo $produit['prix'];?>€</p>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col-md-12 px-0" style="height:2px; width:100%; border-bottom: 1px solid black;"></div>
    </div>
    <div class="row mt-2">
      <div class="col-md-12 px-0">
        <h5>Autres Produits</h5>
      </div>
    </div>
    <div class="row mt-2">
    
    <?= $vignettes ?>
    
    </div>
    
    <!-- DEBUT DU MODULE DEPOSER UN COMMENTAIRE -->
    <?php if( userConnect() ) : ?>
    
    <section id="commentaire" style="background:lightgrey; border-radius:5px;" class="px-4 py-4 mt-5">
      <div class="row">
        <div class="col-md-12">
          <h5 class="mb-3">Déposer un commentaire et noter la salle</h5>
        </div>
      </div>
      <form method="POST"  action="fiche_produit.php?id_produit=<?php echo $produit['id_produit']; ?>">
        <div class="form-row">
          <div class="col-sm-8 my-1">
            <div class="form-group">
              <textarea class="form-control" name="commentaire" id="commentaire" placeholder="votre commentaire sur la salle"></textarea>
            </div>
          </div>
          <div class="col-sm-2 my-1">
            <select class="form-control" id="note" name="note">
              <option value="0" selected>☆☆☆☆☆</option>
              <option value="1">★☆☆☆☆</option>
              <option value="2">★★☆☆☆</option>
              <option value="3">★★★☆☆</option>
              <option value="4">★★★★☆</option>
              <option value="5">★★★★★</option>
            </select>
          </div>
          <div class="col-sm-2 my-1">
            <div class="form-group">
              <input type="text" name="membreID" value="<?php echo $_SESSION['membre']['id_membre'];?>" style="display:none">
              <input type="text" name="salleID" value="<?php echo $salle['id_salle'];?>" style="display:none">
              <input type="submit" class="form-control" name="notation">
            </div>
          </div>
        </div>
      </form>
    </section>
    
    <?php endif; ?>
    <!-- FIN DU MODULE DEPOSER UN COMMENTAIRE -->
    
    <div class="row mt-5">
      <div class="col-md-12">
        <h6 class="float-right"><a href="index.php">Retour vers le catalogue</a></h6>
      </div>
    </div>

<?php require_once('inc/footer.inc.php');?>
