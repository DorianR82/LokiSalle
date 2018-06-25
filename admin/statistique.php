<?php require_once('inc/header.admin.inc.php');?>
<?php

$content .= '<h3 class="mt-5">Statistiques</h3>
                <div class="row mt-3 mb-4">
                <div class="col-md-12 px-0" style="height:2px; width:100%; border-bottom: 1px solid black;"></div>
                </div>';
$content .= '<a href="?action=top5notes">Top 5 des salles les mieux notées</a><br><hr>';
$content .= '<a href="?action=top5commande">Top 5 des salles les plus commandées</a><br><hr>';
$content .= '<a href="?action=top5quantite">Top 5 des membres qui achètent le plus (quantité)</a><br><hr>';
$content .= '<a href="?action=top5valeur">Top 5 des membres qui achétent le plus (en terme de prix)</a><br><hr><br><br>';


//Affichage des salles les mieux notées:
if( isset($_GET['action']) && $_GET['action'] == 'top5notes' ){
      $r = execute_requete(' SELECT a.id_salle, ROUND(AVG(a.note) ,0) AS "Rounded Avg.", s.titre
      FROM avis a, salle s WHERE a.id_salle = s.id_salle
      GROUP BY a.id_salle
      ORDER BY a.note DESC
      LIMIT 5
      ');


        $content .= '<h2>Top 5 des salles les mieux notées</h2>';
        $content .= '<table class="table table-dark table-striped text-center">';
        $content .= '<tr>
                <th>Classement</th>
                <th>Id salle - Nom de la salle</th>
                <th>Moyenne des notes</th>
        </tr>';

          $i=1;
          while ($ligne = $r->fetch(PDO::FETCH_ASSOC)) {
            $content .= '<tr>';
            $content .= '<td>' . $i++ . '</td>';
            $content .= '<td>' . $ligne['id_salle'] . ' - ' .$ligne['titre'] .'</td>';
            $content .= '<td>' . $ligne['Rounded Avg.'] . '</td>';
            $content .= '</td>
            </tr>';
            }
            $content .= '</table>';
            }
//Fin de l'Affichage des salles les mieux notées



//Affichage des salles les plus commandées:
if( isset($_GET['action']) && $_GET['action'] == 'top5commande' ){
      $r = execute_requete(' SELECT p.id_salle, s.titre, c.id_produit, COUNT(*) as occurence_produit
      FROM produit p, commande c, salle s
      WHERE c.id_produit = p.id_produit
      AND p.id_salle = s.id_salle
      GROUP BY id_produit
      ORDER BY occurence_produit
      DESC LIMIT 5
 ');

        $content .= '<h2>Top 5 des salles les plus commandées</h2>';
        $content .= '<table class="table table-dark table-striped text-center">';
        $content .= '<tr>
                <th>Classement</th>
                <th>Id salle - Nom de la salle</th>
                <th>Nombre de commandes passées</th>
        </tr>';

          $i=1;
          while ($ligne = $r->fetch(PDO::FETCH_ASSOC)) {
            $content .= '<tr>';
            $content .= '<td>' . $i++ . '</td>';
            $content .= '<td>' . $ligne['id_salle'] . ' - ' .$ligne['titre'] .'</td>';
            $content .= '<td>' . $ligne['occurence_produit'] . '</td>';
            $content .= '</td>
            </tr>';
            }
            $content .= '</table>';
            }
//Fin de l'Affichage des salles les plus commandées.


//Affichage des membres qui ont commandé le plus (en quantité):
if( isset($_GET['action']) && $_GET['action'] == 'top5quantite' ){
      $r = execute_requete(' SELECT m.nom, m.prenom, m.email, c.id_membre, COUNT(*) AS occurence_membre
      FROM commande c, membre m
      WHERE c.id_membre = m.id_membre
      GROUP BY id_membre
      ORDER BY occurence_membre
      DESC LIMIT 5
');

        $content .= '<h2>Top 5 des membres qui achètent le plus (quantité)</h2>';
        $content .= '<table class="table table-dark table-striped text-center">';
        $content .= '<tr>
                <th>Classement</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>email</th>
                <th>Nombre de commande passées</th>
        </tr>';

          $i=1;
          while ($ligne = $r->fetch(PDO::FETCH_ASSOC)) {
            $content .= '<tr>';
            $content .= '<td>' . $i++ . '</td>';
            $content .= '<td>' . $ligne['nom'] .'</td>';
            $content .= '<td>' . $ligne['prenom'] .'</td>';
            $content .= '<td>' . $ligne['email'] .'</td>';
            $content .= '<td>' . $ligne['occurence_membre'] .'</td>';
            $content .= '</td>
            </tr>';
            }
            $content .= '</table>';
            }
//Fin de l'affichage des membres qui ont commandé le plus (en quantité)


//Affichage des membres qui ont commandé le plus (en valeur):
if( isset($_GET['action']) && $_GET['action'] == 'top5valeur' ){
      $r = execute_requete(' SELECT m.nom, m.prenom, m.email, c.id_membre, SUM(p.prix) AS somme_prix
      FROM commande c, produit p, membre m
      WHERE c.id_membre = m.id_membre
      AND p.id_produit = c.id_produit
      GROUP BY c.id_membre
      ORDER BY somme_prix
      DESC LIMIT 5
 ');
        $content .= '<h2>Top 5 des membres qui achètent le plus (en valeur)</h2>';
        $content .= '<table class="table table-dark table-striped text-center">';
        $content .= '<tr>
                <th>Classement</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>email</th>
                <th>Valeur des commandes passées</th>
        </tr>';

          $i=1;
          while ($ligne = $r->fetch(PDO::FETCH_ASSOC)) {
            $content .= '<tr>';
            $content .= '<td>' . $i++ . '</td>';
            $content .= '<td>' . $ligne['nom'] .'</td>';
            $content .= '<td>' . $ligne['prenom'] .'</td>';
            $content .= '<td>' . $ligne['email'] .'</td>';
            $content .= '<td>' . $ligne['somme_prix'] .' € </td>';
            $content .= '</td>
            </tr>';
            }
            $content .= '</table>';
            }
//Fin de l'affichage des membres qui ont commandé le plus (en valeur)


?>
<?= $content ?>



<?php require_once('inc/footer.admin.inc.php');?>
