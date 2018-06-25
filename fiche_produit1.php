<?php require_once('inc/header.inc.php');?>

<?php

if( isset($_GET['id_produit']) ){
      $resproduit = execute_requete("SELECT * FROM produit WHERE id_produit = '$_GET[id_produit]' ");
      $ressalle = execute_requete("SELECT * FROM salle WHERE id_salle = (SELECT id_salle from produit WHERE id_produit = '$_GET[id_produit]') ");

      $produit = $resproduit->fetch(PDO::FETCH_ASSOC);
      $salle = $ressalle->fetch(PDO::FETCH_ASSOC);

      // Libéré la partis en commentaire dans la requete pour la version finale.
      $caca = execute_requete("SELECT MIN(salle.id_salle) AS min,MAX(salle.id_salle)AS max,salle.photo FROM produit INNER JOIN salle ON produit.id_salle = salle.id_salle WHERE produit.etat = 'libre' /*AND produit.date_arrivee = '".$produit['date_arrivee']."' AND salle.ville = '".$salle['ville']."'*/" );

      $proposition = $caca->fetch(PDO::FETCH_ASSOC);


         $resNotes = execute_requete("SELECT note FROM avis WHERE id_salle = $produit[id_salle] GROUP BY id_membre");
         $recupNote = $resNotes->fetch(PDO::FETCH_ASSOC);
            var_dump($recupNote);
         while($recupNote = $resNotes->fetch(PDO::FETCH_ASSOC)){
            var_dump ($recupNote);
         }

}else{
       header('location:index.php');
   exit();
}

//var_dump($_SESSION);
//var_dump($resproduit);
//var_dump($produit);
//var_dump($ressalle);
//var_dump($salle);
//var_dump($caca);
//var_dump($proposition);

if($_POST){
  $enregistrement = date("Y\-m\-d\ h:i:s");
  //var_dump($enregistrement);
  //var_dump($_POST);

  if(isset ($_POST['reservation'])){
    execute_requete("UPDATE produit SET etat = 'reservation' WHERE id_produit = $_POST[produitID]");
    execute_requete("INSERT INTO commande (id_membre,id_produit,date_enregistrement) VALUES ($_POST[membreID],$_POST[produitID],'$enregistrement')");

  }
  if (isset ($_POST['notation'])){
    $prout = execute_requete("SELECT*FROM avis WHERE id_membre = '$_POST[membreID]'");
    $zizi = $prout->fetch(PDO::FETCH_ASSOC);

    if($_POST['salleID'] == $zizi['id_salle']){
      execute_requete("UPDATE avis SET note = $_POST[note],commentaire = $_POST[commentaire],date_enregistrement = $enregistrement WHERE id_salle = $_POST[salleID]");
    }else{
      execute_requete("INSERT INTO avis (id_membre,id_salle,note,commentaire,date_enregistrement) VALUES ('$_POST[membreID]','$_POST[salleID]','$_POST[note]','$_POST[commentaire]',NOW())");
    }
  }
}

//affichage de la note

?>



        <div class="row mt-3">
                <div class="col-md-7 px-0">
                  <h2>
                     <?php echo $salle['titre'].' ';
                     for ($i=0; $i < $etoile['note']; $i++) {
                        echo '★';
                     }
                     $etoilevide = 5 - $etoile['note'];
                     for ($i=0; $i < $etoilevide; $i++) {
                     echo '☆';
                  }
                  ?></h2>
                </div>
                  <div class="col-md-5 px-0">
                     <form method="POST" action="">

                    <?php
                    echo '
                    <input type="text" name="membreID" value="'.$_SESSION['membre']['id_membre'].'" style="display:none">
                    <input type="text" name="produitID" value="'.$produit['id_produit'].'" style="display:none">

                    <input type="submit" class="btn btn-dark float-right" name="reservation" value="Reserver">';
                    ?>

                  </div>
                </form>
        </div>
        <div class="row mt-3">
                <div class="col-md-12 px-0" style="height:2px; width:100%; border-bottom: 1px solid black;"></div>
        </div>
        <div class="row mt-4">
                <div class="col-md-7 px-0">
                        <img src="<?php echo $salle['photo'];?>" class="w-100"></a>
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
                <?php
                for ($i=0;$i<4;$i++){
                  $id_randomizer = rand($proposition['min'],$proposition['max']);
                  // Libéré la partis en commentaire dans la requete pour la version finale.
                  $pipi = execute_requete("SELECT produit.id_produit,salle.photo FROM produit JOIN salle ON produit.id_salle = salle.id_salle WHERE salle.id_salle = '$id_randomizer' /*AND id_salle != '".$produit['id_salle']."'*/");
                  $photo = $pipi->fetch(PDO::FETCH_ASSOC);

                  //debug($id_randomizer);
                  //debug($pipi);
                  //debug($photo);
                echo '
                <div class="col-md-3">
                        <a href="fiche_produit.php?id_produit='.$photo['id_produit'].'"><img src="'.$photo['photo'].'" class="w-100"></a>
                </div>';
                }
                ?>
        </div>


        <!-- DEBUT DU MODULE DEPOSER UN COMMENTAIRE -->
                 <section id="commentaire"style="background:lightgrey; border-radius:5px;" class="px-4 py-4 mt-5">
                    <div class="row">
                       <div class="col-md-12">
                          <h5 class="mb-3">Déposer un commentaire et noter la salle</h5>
                       </div>
                    </div>
                    <div class="row">
                       <div class="col-md-8">
                          <?php echo'
                          <form method="POST" action="">
                             <div class="form-group">
                                <textarea class="form-control" name="commentaire" id="commentaire" placeholder="votre commentaire sur la salle"></textarea>
                          </div>
                       </div>
                       <div class="col-md-2">
                          <div class="form-group">
                             <select class="form-control" id="note" name="note">
                                <option value="0" selected>☆☆☆☆☆</option>
                                <option value="1">★☆☆☆☆</option>
                                <option value="2">★★☆☆☆</option>
                                <option value="3">★★★☆☆</option>
                                <option value="4">★★★★☆</option>
                                <option value="5">★★★★★</option>
                             </select>
                          </div>
                       </div>
                       <div class="col-md-2">
                          <div class="form-group">
                           <input type="text" name="membreID" value="'.$_SESSION['membre']['id_membre'].'" style="display:none">
                           <input type="text" name="salleID" value="'.$salle['id_salle'].'" style="display:none">
                           <input type="submit" name="notation">
                         </div>
                       </div>
                    </form>'
                     ?>
                 </div>
              </section> <!-- FIN DU MODULE DEPOSER UN COMMENTAIRE -->

                 <div class="row mt-5">
                    <div class="col-md-12">
                                <h6 class="float-right"><a href="index.php">Retour vers le catalogue</a></h6>
                        </div>
                </div>

<?php require_once('inc/footer.inc.php');?>
