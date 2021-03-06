<?php require_once('inc/header.inc.php');?>
<?php
//********************* PHP ***********************//

  ///////////////////////////
 // Filtre du formulaire. //
///////////////////////////

if(isset($_GET['filtre'])){
  $filtre = '';  
  if(isset ($_GET['categorie'])){
    $filtre .= ' AND salle.categorie = \''.$_GET['categorie'].'\'';
  }
  if(isset ($_GET['ville'])){
    $filtre .= ' AND salle.ville = \''.$_GET['ville'].'\'';
  }
  if(isset ($_GET['capaciteSalle']) && $_GET['capaciteSalle'] != 'Sélectionner'){
    $filtre .= ' AND salle.capacite <= '.$_GET['capaciteSalle'];
  }
  if(isset ($_GET['prix']) && $_GET['prix'] != 0){
    $filtre .= ' AND produit.prix <= '.$_GET['prix'];
  }
  if(isset ($_GET['dateArrivee']) && $_GET['dateArrivee'] != ''){
    $filtre .= ' AND produit.date_arrivee >= \''.$_GET['dateArrivee'].'\'';
  }
  if(isset ($_GET['dateDepart']) && $_GET['dateDepart'] != ''){
    $filtre .= ' AND produit.date_depart <= \''.$_GET['dateDepart'].'\'';
  }
  //var_dump($_GET);
  //var_dump($filtre);

    ///////////////////////////////////////
   // Requete de Selection de l'usager. //
  ///////////////////////////////////////

  $r_index = execute_requete
  ("SELECT * FROM produit
      JOIN salle
        ON produit.id_salle = salle.id_salle
      WHERE
        produit.etat = 'libre'
        $filtre
      ORDER BY produit.id_produit ASC");
}else{
  $r_index = execute_requete
  ("SELECT * FROM produit 
      JOIN salle
        ON produit.id_salle = salle.id_salle
      WHERE produit.etat = 'libre'
      ORDER BY produit.id_produit ASC");
}
//var_dump($r_index);

//================================================================

  //////////////////////////////////////////////
 // Affichage résultat de recherche filtrer. //
//////////////////////////////////////////////

$reponse_du_filtre = '';

if($r_index->rowCount() == 0){

  $reponse_du_filtre .= '
  <div class="col-lg-12 col-md-6 mb-4 mt-5">
    <div class="card h-100">
      <h1 style="text-align:center">Aucune correspondance</h1>
    </div>
  </div>';

}else{

  while($index = $r_index->fetch(PDO::FETCH_ASSOC)){

    $resNote = execute_requete(
      "SELECT ROUND(AVG(note))
      AS note
      FROM avis
      JOIN salle
        ON avis.id_salle = salle.id_salle
      JOIN produit
        ON salle.id_salle = produit.id_salle
      WHERE avis.id_salle = $index[id_salle]
      ");
      $moyenne = $resNote->fetch(PDO::FETCH_ASSOC);
      $etoilevide = 5 - $moyenne['note'];
  
  $reponse_du_filtre .= '
  <div class="col-lg-4 col-md-6 mb-4 mt-5">
    <div class="card h-100">
      <a href="fiche_produit.php?id_produit='. $index['id_produit'] .'">
        <img class="card-img-top" src="'. $index['photo'] .'" alt="" height ="180px">
      </a>
      <div class="card-body">
        <a href="fiche_produit.php?id_produit='. $index['id_produit'] .'" style="color:black;">
          <h4 class="card-title mb-2">'. $index['titre'] .'</h4>
          <h5 class="float-left">'.$index['ville'].' </h5><h5 class="float-right">'. $index['prix'] .' €</h5><br>
          <p class="card-text float-left">'. tronque($index['description'],60) .'</p>
        </a>
      </div>
      <div class="card-footer">
        <small class="text-muted">';

        ////////////////////////////////////////////////
       // Affichage des petites étoiles de notation. //
      ////////////////////////////////////////////////

      for ($i=0; $i < $moyenne['note']; $i++) {
        $reponse_du_filtre .= '&#9733;';
      }
      for ($i=0; $i < $etoilevide; $i++) {
        $reponse_du_filtre .= '&#9734;';
      }
        $reponse_du_filtre .= '
        </small><br>
        <!--
        <small class="text-muted">[ID PRODUIT = '. $index['id_produit'].' ]</small><br>
        <small class="text-muted">[ID SALLE = '. $index['id_salle'].' ]</small><br>
        <small class="text-muted">[CATEGORIE = '. $index['categorie'] .' ]</small><br>
        <small class="text-muted">[NOTE = '. $moyenne['note'] .' ]</small><br>
        <small class="text-muted">[CAPACITE = '. $index['capacite'] .' ]</small><br>
        <small class="text-muted">[ARRIVEE = '. $index['date_arrivee'] .' ]</small><br>
        <small class="text-muted">[DEPART = '. $index['date_depart'] .' ]</small><br>
        -->
      </div>
    </div>
  </div>';
  }
};

//********************* FIN PHP ***********************//
?>

      <div class="row">
        <div class="col-lg-3 pr-5">
          <form method="GET" style="background:lightgrey; border-radius: 5px; padding: 10px;" class="mt-5 mb-2">
            <label for="categorie"><h5 class="mt-2 mb-0">Catégorie</h5></label><br>
            <input type="radio" name="categorie" value="bureau" a href="?action=tri&categorie=bureau"> Bureau<br>
            <input type="radio" name="categorie" value="formation" a href="?action=tri&categorie=formation"> Formation<br>
            <input type="radio" name="categorie" value="reunion" a href="?action=tri&categorie=reunion"> Réunion<br>

            <label for="ville"><h5 class="mt-4 mb-0">Ville</h5></label><br>
            <input type="radio" name="ville" value="paris" a href="?action=tri&ville=paris"> Paris<br>
            <input type="radio" name="ville" value="lyon" a href="?action=tri&ville=paris"> Lyon<br>
            <input type="radio" name="ville" value="marseille" a href="?action=tri&ville=paris"> Marseille<br>

            <label for="capaciteSalle"><h5 class="mt-4 mb-0">Capacité des salles</h5></label>
            <select name="capaciteSalle" class="form-control">
              <option><a href="#" class="list-group-item">Sélectionner</a></option>
              <option value="10"><a href="?action=tri&capacite=10" class="list-group-item">10 personnes</a></option>
              <option value="20"><a href="?action=tri&capacite=20" class="list-group-item">20 personnes</a></option>
              <option value="30"><a href="?action=tri&capacite=30" class="list-group-item">30 personnes</a></option>
              <option value="40"><a href="?action=tri&capacite=40" class="list-group-item">40 personnes</a></option>
              <option value="50"><a href="?action=tri&capacite=50" class="list-group-item">50 personnes</a></option>
              <option value="60"><a href="?action=tri&capacite=60" class="list-group-item">60 personnes</a></option>
              <option value="70"><a href="?action=tri&capacite=70" class="list-group-item">70 personnes</a></option>
              <option value="80"><a href="?action=tri&capacite=80" class="list-group-item">80 personnes</a></option>
              <option value="90"><a href="?action=tri&capacite=90" class="list-group-item">90 personnes</a></option>
              <option value="10"><a href="?action=tri&capacite=100" class="list-group-item">100 personnes</a></option>
            </select>

            <label for="prix"><h5 class="mt-4 mb-2">Prix</h5></label>
            <div class="row">
              <div class="col-4">
                <h6 style="font-size:13px;" class="float-left">O€</h6>
              </div>
              <div class="col-4 text-center">
                <h6 style="font-size:13px;">500€</h6>
              </div>
              <div class="col-4">
                <h6 style="font-size:13px;" class="float-right">1000€</h6>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <input type="range" name="prix" value="0" min="0" max="1000" style="width:100%"; list="tickmarks"  step="100">
                <!--
                <datalist id="tickmarks">
                  <option value="0">
                  <option value="100">
                  <option value="200">
                  <option value="300">
                  <option value="400">
                  <option value="500">
                  <option value="600">
                  <option value="700">
                  <option value="800">
                  <option value="900">
                  <option value="1000">
                </datalist>
                -->
              </div>
            </div>

            <label for="dateArrivee"><h5 class="mt-4 mb-1">Date d'arrivée</h5></label>
            <input type="date" id="dateArrivee" name="dateArrivee" style="width:100%; border-radius:5px; border:1px solid #ced4da; padding:4px;">

            <label for="dateDepart"><h5 class="mt-4 mb-1">Date de départ</h5></label>
            <input type="date" id="dateDepart" name="dateDepart" style="width:100%; border-radius:5px; border:1px solid #ced4da; padding:4px;">

            <div class="mt-4 mb-1">
              <input type="submit" name="filtre" style="width:100%; border-radius:5px; background-color: white; border:1px solid white; padding:4px;">
            </div>
          </form>
        </div>
        <!-- /.col-lg-3 -->
        <div class="col-lg-9">
          <div class="row">
          
          <!-- Insertion de PHP -->
          <?= $reponse_du_filtre ?>

          </div>
          <!-- /.row -->
        </div>
        <!-- /.col-lg-9 -->
      </div>
      <!-- /.row -->
<?php require_once('inc/footer.inc.php');?>