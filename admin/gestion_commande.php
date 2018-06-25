<?php require_once('inc/header.admin.inc.php');?>
<?php
//================================================================
//Suppression d'une commande:
if(isset($_GET['action']) && $_GET['action'] == 'suppression' ){
        execute_requete("DELETE FROM commande WHERE id_commande = $_GET[id_commande]");
}
//================================================================
//Affichage des membres:

$r = execute_requete('SELECT c.id_commande, m.id_membre, m.email, s.id_salle, s.titre, p.date_arrivee, p.date_depart, p.prix, c.date_enregistrement
                     FROM commande c, membre m, produit p, salle s WHERE c.id_membre = m.id_membre AND c.id_produit = p.id_produit AND p.id_salle = s.id_salle');

$content .= '<h6 class="mt-5 mb-4">Nombre de commandes référencées :  '.$r->rowCount().' </h6>';


$content .= '<table class="table table-dark text-center">
                <tr>
                        <th>id commande</th>
                        <th>id membre</th>
                        <th>id produit</th>
                        <th>prix</th>
                        <th>date d\'enregistrement</th>
                        <th colspan=2>actions</th>
                </tr>';
                while ($ligne = $r->fetch(PDO::FETCH_ASSOC)) {
                $content .= '<tr>';
                        $content .= '<td>' . $ligne['id_commande'] . '</td>';
                        $content .= '<td>' . $ligne['id_membre'] . ' - ' .$ligne['email'] .'</td>';
                        $content .= '<td>' . $ligne['id_salle'] . ' - ' .$ligne['titre']. '<br> du ' .$ligne['date_arrivee']. ' au ' .$ligne['date_depart'] . '</td>';
                        $content .= '<td>' . $ligne['prix'] . '</td>';
                        $content .= '<td>' . $ligne['date_enregistrement'] . '</td>';
                        $content .= '<td><a href="?action=suppression&id_commande='.$ligne['id_commande'].'"  onClick="return( confirm(\'En êtes vous scertain?\') )" ><i class="fas fa-trash-alt"></i></a></td>
                </tr>';
                }
$content .= '</table>';



?>
<h3 class="mt-5">GESTION DES COMMANDES</h3>
<div class="row mt-3">
<div class="col-md-12 px-0" style="height:2px; width:100%; border-bottom: 1px solid black;"></div>
</div>
<?= $content ?>
<?php require_once('inc/footer.admin.inc.php');?>
