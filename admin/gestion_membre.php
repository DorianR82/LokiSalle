<?php require_once('inc/header.admin.inc.php');?>
<?php
//================================================================
//Modification des membres:

if($_POST){
  execute_requete("UPDATE membre SET
    pseudo = '$_POST[pseudo]',
    nom = '$_POST[nom]',
    prenom = '$_POST[prenom]',
    email = '$_POST[email]',
    civilite = '$_POST[civilite]',
    statut = '$_POST[statut]'
  WHERE id_membre = '$_GET[id_membre]'");
  $content .= '<div class="alert alert-success">Le compte membre a été mis a jour!</div>';
}

//================================================================
//Suppression d'un membre:

if(isset($_GET['action']) && $_GET['action'] == 'suppression' ){execute_requete("DELETE FROM membre WHERE id_membre = $_GET[id_membre]");}

//================================================================
//Placeholder pour modification membre:

if(isset($_GET['action']) && $_GET['action'] == 'modification' ){
  $r = execute_requete("SELECT * FROM membre WHERE id_membre=$_GET[id_membre]");
  $membre = $r->fetch(PDO::FETCH_ASSOC);
}

$id_membre = ( isset($membre['id_membre']) ) ? $membre['id_membre'] : '';
$pseudo = ( isset($membre['pseudo']) ) ? $membre['pseudo'] : '';
$nom = ( isset($membre['nom']) ) ? $membre['nom'] : '';
$prenom = ( isset($membre['prenom']) ) ? $membre['prenom'] : '';
$email = ( isset($membre['email']) ) ? $membre['email'] : '';
$civilite = ( isset($membre['civilite']) ) ? $membre['civilite'] : '';
$statut = ( isset($membre['statut']) ) ? $membre['statut'] : '';
$date_inscription = (isset($membre['date_inscription'])) ? $membre['date_inscription'] : '';

//================================================================
// Affichage du formulaie de modification.

$content .= '
<form method="post">
  <div class="form-group mt-5">
    <label for="pseudo">Pseudo</label>
    <input type="text" name="pseudo" id="pseudo" placeholder="pseudo" class="form-control" value="'.$pseudo.'">
  </div>
  <div class="form-group">
    <label for="sexe">Titre de civilité</label>
    <select class="form-control" id="sexe" name="civilite">';

    $content .= '
      <option value="F" ';if($civilite == 'F')$content .= ' selected';$content .= '>Madame</option>';
    $content .= '
      <option value="M" ';if($civilite == 'M')$content .= ' selected';$content .='>Monsieur</option>';
  
  $content .= '
    </select>
  </div>
  <div class="form-group">
    <label for="nom">Nom</label>
    <input type="text" name="nom" id="nom" placeholder="nom" class="form-control" value="'.$nom.'">
  </div>
  <div class="form-group">
    <label for="prenom">Prénom</label>
    <input type="text" name="prenom" id="prenom" placeholder="prenom" class="form-control" value="'.$prenom.'">
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="text" name="email" id="email" placeholder="email" class="form-control" value="'.$email.'">
  </div>
  <div class="form-group">
    <label for="statut">Statut</label>
    <select class="form-control" id="statut" name="statut">';

    $content .= '
      <option value="0" ';if($statut == 0 )$content .= ' selected';$content .= '>Membre</option>';    
    $content .= '
      <option value="1" ';if($statut == 1 )$content .= ' selected';$content .='>Admin</option>';

  $content .= '
    </select>
  </div>
  <div class="form-group">
    <input type="submit">
  </div>
</form>';

//================================================================
// Affichage des membres.

$r = execute_requete('SELECT * FROM membre');
$content .= '<h6 class="mt-5 mb-4">Affichage des '.$r->rowCount().' membres :</h6>';
$content .= '<table class="table table-dark table-striped text-center"><tr>';
for ($i=0; $i < $r->columnCount() ; $i++) {
    $colonne = $r->getColumnMeta($i);
    if($colonne['name'] == 'id_membre'){
        $content .= "<th>ID</th>";
    }
    if($colonne['name'] == 'date_inscription'){
        $content .= "<th>Inscription</th>";
    }
    if($colonne['name'] != 'mdp' && $colonne['name'] != 'id_membre' && $colonne['name'] != 'date_inscription'){
        $content .= "<th>$colonne[name]</th>";
    }
}
$content .= '<th colspan="2">Actions</th>';
$content .= '</tr>';
while( $membre = $r->fetch(PDO::FETCH_ASSOC) ){
    $content .= '<tr>';
    foreach ($membre as $indice => $valeur) {
        if($indice == 'civilite'){
            if($valeur == 'M'){
                $content .= "<td>Masculin</td>";
            }else{
                $content .= "<td>Femelle</td>";
                }
        }
        if($indice == 'statut'){
                if($valeur == 1){
                        $content .= "<td>Admin</td>";
                }else{
                        $content .= "<td>Membre</td>";
                }
        }
        if( $indice != 'mdp' && $indice != 'civilite' && $indice != 'statut'){
            $content .= "<td>$valeur</td>";
        }
    }
    $content .= '<td><a href="?action=modification&id_membre='.$membre['id_membre'].'"><i class="fas fa-pencil-alt"></i></a></td>';
    $content .= '<td>
        <a href="?action=suppression&id_membre='.$membre['id_membre'].'"  onClick="return(confirm(\'Supprimer le compte de '.$membre['prenom'].' '.$membre['nom'].'?\') )" ><i class="fas fa-trash-alt"></i></a>
    </td>';
    $content .= '</tr>';
}
$content .= '</table>';

?>
<h3 class="mt-5">GESTION DES MEMBRES</h3>
<div class="row mt-3">
<div class="col-md-12 px-0" style="height:2px; width:100%; border-bottom: 1px solid black;"></div>
</div>
<?= $content ?>
<?php require_once('inc/footer.admin.inc.php');?>
