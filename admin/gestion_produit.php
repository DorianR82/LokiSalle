<?php require_once('inc/header.admin.inc.php');?>
<?php

$content .= '<h3 class="mt-5">GESTION DES PRODUITS</h3>
                <div class="row mt-3 mb-4">
                <div class="col-md-12 px-0" style="height:2px; width:100%; border-bottom: 1px solid black;"></div>
                </div>';
$content .= '<a href="?action=affichage">Affichage des produits</a><br>';
$content .= '<a href="?action=ajout">Ajout d\'un produit</a><br><hr>';

//Suppression d'un produit:
if( isset($_GET['action']) && $_GET['action'] == 'suppression'){
        $r = execute_requete("SELECT * FROM produit WHERE id_produit='$_GET[id_produit]'");
        $produit_a_supprimer = $r->fetch(PDO::FETCH_ASSOC);
        execute_requete("DELETE FROM produit WHERE id_produit=$_GET[id_produit]");
        header('location:gestion_produit.php?action=affichage');
}

//Enregistrement des produits:
if(!empty($_POST)){
        var_dump($_POST);

        $dateA = date_create_from_format('d/m/Y H:i',($_POST['date_arrivee']));
        $arrivee =  date_format($dateA, 'Y-m-d H:i');

        $dateD = date_create_from_format('d/m/Y H:i',$_POST['date_depart']);
        $depart =  date_format($dateD, 'Y-m-d H:i');

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
        $content .= '<table class="table table-dark table-striped text-center">';
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
                $content .= '<td><a href="?action=modification&id_produit='.$ligne['id_produit'].'"><i class="fas fa-pencil-alt"></i></a></td>';
                $content .= '<td><a href="?action=suppression&id_produit='.$ligne['id_produit'].'" onClick="return(confirm(\'En êtes vous certain ?\'))"><i class="fas fa-trash-alt"></i></a></td>';
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

$date_arrivee = ( isset($produit_actuel['date_arrivee']) )  ? date_format(date_create($produit_actuel['date_arrivee']),'d/m/Y H:i') : '' ;
$date_depart = ( isset($produit_actuel['date_depart']) )  ? date_format(date_create($produit_actuel['date_depart']),'d/m/Y H:i') : '' ;
$capacite = ( isset($produit_actuel['capacite']) )  ? $produit_actuel['capacite'] : '' ;

$id_salle = ( isset($produit_actuel) && $produit_actuel['id_salle'] == '') ? ' selected':'' ;
$taille_s = ( isset($article_actuel) && $article_actuel['taille'] == 'S') ? ' selected' :'' ;

$prix = ( isset($produit_actuel['prix']) )  ? $produit_actuel['prix'] : '' ;
//$prix = '';
        $content .='
        <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                        <label for="date_arrivee">Date Arrivée</label><br>
                        <input type="text" name="date_arrivee" class="form-control" id="date_arrivee" value="'.$date_arrivee.'" placeholder="00/00/0000 00:00">
                </div>
                <div class="form-group">
                        <label for="date_depart">Date Départ</label><br>
                        <input type="text" name="date_depart" class="form-control" id="date_depart" value="'.$date_depart.'" placeholder="00/00/0000 00:00">
                </div>
                <div class="form-group">
                        <label for="id_salle">Salle</label><br>
                        <select name="id_salle" id="id_salle" class="form-control">';
                        $salle = execute_requete("SELECT * FROM salle");
                        while ($ligne = $salle->fetch(PDO::FETCH_ASSOC)){
                                $content .= '<option value="';$content .= $ligne['id_salle'];$content .= '">'
                                .$ligne['titre'].' - '
                                .$ligne['capacite'].' Pers. - '
                                .$ligne['adresse'].' - '
                                .$ligne['ville'].' - '
                                .$ligne['cp'].' - '
                                .$ligne['pays'].'</option>';
                        }
                        $content .='
                        </select>
                </div>
                <div class="form-group">
                        <label for="prix">Tarif</label>
                        <input type="text" name="prix" id="prix" class="form-control" value="'.$prix.'" placeholder="Prix en €uros">
                </div>
                        <div class="form-group">
                        <input type="submit" value="'.ucfirst($_GET['action']).'">
                </div>
        </form>';
}
?>
<?= $content ?>




<?php require_once('inc/footer.admin.inc.php');?>
