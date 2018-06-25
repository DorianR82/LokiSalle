<?php require_once('inc/header.admin.inc.php');?>
<?php
$content .= '<h3 class="mt-5">GESTION DES SALLES</h3>
                <div class="row mt-3 mb-4">
                <div class="col-md-12 px-0" style="height:2px; width:100%; border-bottom: 1px solid black;"></div>
                </div>';
$content .= '<a href="?action=affichage">Affichage des salles</a><br>';
$content .= '<a href="?action=ajout">Ajout d\'une salle</a><br><hr>';
//================================================================
//Suppression d'une Salle:
if( isset($_GET['action']) && $_GET['action'] == 'suppression'){
        $r = execute_requete("SELECT * FROM salle WHERE id_salle='$_GET[id_salle]'");
        $salle_a_supprimer = $r->fetch(PDO::FETCH_ASSOC);
        //$modif = str_replace('http://localhost',$_SERVER['DOCUMENT_ROOT'],$salle_a_supprimer);
        $modif = str_replace('http://serverapache',$_SERVER['DOCUMENT_ROOT'],$salle_a_supprimer);
        $chemin_Photo_a_Supprimer = $modif['photo'];
        if(!empty($chemin_Photo_a_Supprimer)&&file_exists($chemin_Photo_a_Supprimer)){
                unlink($chemin_Photo_a_Supprimer);
        }
        execute_requete("DELETE FROM salle WHERE id_salle=$_GET[id_salle]");
        header('location:gestion_salle.php?action=affichage');
}
//================================================================
//Enregistrement des salles:
if(!empty($_POST)){
        $photo_bdd = '';
        if( isset($_GET['action']) && $_GET['action'] == 'modification'){
                $photo_bdd = $_POST['photo_actuelle'];
        }
        if( !empty($_FILES['photo']['name']) ){
                $nom_photo = $_POST['titre'].'_'.$_FILES['photo']['name'];
                $photo_dossier = $_SERVER['DOCUMENT_ROOT']."/lokisalle/photo/$nom_photo";
                $photo_bdd = URL."photo/$nom_photo";
                copy($_FILES['photo']['tmp_name'], $photo_dossier);
        }
        foreach($_POST as $indice => $valeur ){
                $_POST[$indice] = htmlEntities(addSlashes($valeur));
        }
        if( isset($_GET['action']) && $_GET['action'] == 'modification'){
                execute_requete
                ("UPDATE salle SET
                        titre = '$_POST[titre]',
                        description = '$_POST[description]',
                        photo = '$photo_bdd',
                        pays = '$_POST[pays]',
                        ville = '$_POST[ville]',
                        adresse = '$_POST[adresse]',
                        cp = '$_POST[cp]',
                        capacite = '$_POST[capacite]',
                        categorie = '$_POST[categorie]'
                WHERE id_salle = '$_GET[id_salle]' ");
        }else{
                execute_requete("
                INSERT INTO salle (
                        titre,
                        description,
                        photo,
                        pays,
                        ville,
                        adresse,
                        cp,
                        capacite,
                        categorie
                )VALUES(
                        '$_POST[titre]',
                        '$_POST[description]',
                        '$photo_bdd',
                        '$_POST[pays]',
                        '$_POST[ville]',
                        '$_POST[adresse]',
                        '$_POST[cp]',
                        '$_POST[capacite]',
                        '$_POST[categorie]'
                )");
                $content .= '<div class="alert alert-success">La salle a bien été ajouté.</div>';
        }
}
//================================================================
//Affichage des salles:
if( isset($_GET['action']) && $_GET['action'] == 'affichage' ){
        $r = execute_requete("SELECT * FROM salle");
        $content .= '<h2>Affichage des salles</h2>';
        $content .= 'Nombre de salles référencées : '. $r->rowCount() ;
        $content .= '<table class="table table-dark table-striped text-center">';
        $content .= '<tr>';
                for ($i=0; $i < $r->columnCount() ; $i++){
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

                $content .= '<td><a href="?action=modification&id_salle='.$ligne['id_salle'].'"><i class="fas fa-pencil-alt"></i></a></td>';
                $content .= '<td><a href="?action=suppression&id_salle='.$ligne['id_salle'].'" onClick="return(confirm(\'En êtes vous certain ?\'))"><i class="fas fa-trash-alt"></i></a></td>';
                $content .= '</tr>';
        }
        $content .= '</table>';
}
//================================================================
//Affichage du formulaire:
if( isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification') ){
        if( isset($_GET['id_salle']) ){
                $r = execute_requete("SELECT * FROM salle WHERE id_salle = $_GET[id_salle]");
                $salle_actuel = $r->fetch(PDO::FETCH_ASSOC);
                var_dump($_GET);debug($salle_actuel);
        }

$titre = ( isset($salle_actuel['titre']) )  ? $salle_actuel['titre'] : '' ;
$description = ( isset($salle_actuel['description']) )  ? $salle_actuel['description'] : '' ;
$capacite = ( isset($salle_actuel['capacite']) )  ? $salle_actuel['capacite'] : '' ;

$categorie_Big = ( isset($salle_actuel) && $salle_actuel['categorie'] == 'bureau') ? ' selected' :'' ;
$categorie_Fucking = ( isset($salle_actuel) && $salle_actuel['categorie'] == 'formation') ? ' selected' :'' ;
$categorie_Rocket = ( isset($salle_actuel) && $salle_actuel['categorie'] == 'reunion') ? ' selected' :'' ;

$pays = ( isset($salle_actuel['pays']) )  ? $salle_actuel['pays'] : '' ;
$ville = ( isset($salle_actuel['ville']) )  ? $salle_actuel['ville'] : '' ;
$adresse = ( isset($salle_actuel['adresse']) )  ? $salle_actuel['adresse'] : '' ;
$cp = ( isset($salle_actuel['cp']) )  ? $salle_actuel['cp'] : '' ;

        $content .='
        <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" name="titre" id="titre" class="form-control" value="'.$titre.'" placeholder="Titre de la salle">
                </div>
                <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Descriptif de la salle">'.$description.'</textarea>
                </div>
                <div class="form-group">
                <label for="photo">Photo</label><br>
                <input type="file" name="photo" id="photo" value=""><br>';
                if(isset($salle_actuel) ){
                        $content .= '<i>Vous pouvez uploader une nouvelle photo</i><br>';
                        $content .= '<img src=" '.$salle_actuel['photo'].'" height="120" width="120" ><br>';
                        $content .= '<input type="hidden" name="photo_actuelle" value="'.$salle_actuel['photo'].'"></div>';
                }

                $content .='
                <div class="form-group">
                <label for="capacite">Capacité</label>
                <input type="text" name="capacite" id="capacite" class="form-control" value="'.$capacite.'" placeholder="capacite de la salle">
                </div>
                <div class="form-group">
                <label for="categorie">Catégorie</label>
                <select name="categorie" id="categorie" class="form-control">
                        <option value="bureau" '.$categorie_Big.'>Bureau</option>
                        <option value="formation" '.$categorie_Fucking.'>Formation</option>
                        <option value="reunion" '.$categorie_Rocket.'>Réunion</option>
                </select>
                </div>
                <div class="form-group">
                        <label for="pays">Pays</label>
                        <input type="text" name="pays" id="pays" class="form-control" value="'.$pays.'" placeholder="Pays de la salle">
                </div>
                <div class="form-group">
                        <label for="ville">Ville</label>
                        <input type="text" name="ville" id="ville" class="form-control" value="'.$ville.'" placeholder="Ville de la salle">
                </div>
                <div class="form-group">
                        <label for="adresse">Adresse</label>
                        <textarea id="adresse" name="adresse" class="form-control" placeholder="Adresse de la salle">'.$adresse.'</textarea>
                </div>
                <div class="form-group">
                        <label for="cp">Code Postal</label>
                        <input type="text" name="cp" class="form-control" id="cp" value="'.$cp.'">
                </div>
                        <div class="form-group">
                        <input type="submit" class="form-control" value="'.ucfirst($_GET['action']).'">
                </div>

        </form>';
}
//================================================================?>
<?= $content ?>
<?php require_once('inc/footer.admin.inc.php');?>
