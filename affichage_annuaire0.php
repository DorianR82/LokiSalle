<?php
$pdo = new PDO('mysql:host=localhost;dbname=repertoire', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') );



// FUNCTION debug (elle n'existe pas dans php, il faut la creer)
function debug($arg, $mod=1)
{
    echo '<div style="background: #fda500; padding: 5px;">';
        $trace = debug_backtrace(); // Retourne un array des infos de l'erreur
        echo 'Débug demandé dans le fichier '.$trace[0]['file'].' à la ligne '.$trace[0]['line'];
        if($mod == 1){
            echo '<pre>';
                print_r($arg);
            echo '</pre>';
        } else {
            var_dump($arg);
        }
    echo '</div>';
}

// FUNCTION EXECUTE_REQUETE
function execute_requete($req){
    global $pdo;
    $resultat = $pdo->query($req);
    return $resultat;
}


//declarer la variable avant de l'utiliser sinon elle n'existe pas!! (funtion undefined)
$content='';

//Modification:



        $r = $pdo->query("SELECT * FROM annuaire");

        echo "<table style='border-color:red' border=5><tr>";
        for ($i=0; $i < $r->columnCount() ; $i++) {
                $colonne = $r->getColumnMeta($i);

                echo "<th>$colonne[name]</th>";
        }
        echo '<th>Modification</th>';
        echo '<th>Suppression</th>';
        echo '</tr>';

        while ( $ligne = $r->fetch(PDO::FETCH_ASSOC) ) {

                echo '<tr>';
                        foreach ($ligne as $key => $value) {
                                echo "<td>$value</td>";
                        }
                        echo '<th><a href="?action=modification&id_annuaire='.$ligne['id_annuaire'].'">Modif</a></th>';
                        echo '<th><a href="?action=suppression&id_annuaire='.$ligne['id_annuaire'].'">Suppr</a></th>';
                echo '</tr>';
        }
        echo "</table>";

        $nbr_homme = $pdo->query("SELECT * FROM annuaire WHERE sexe='m' ");
        $nbr_femme = $pdo->query("SELECT * FROM annuaire WHERE sexe='f' ");
        var_dump($nbr_homme);

        echo '<p>Il y a '. $nbr_homme->rowCount( ).' homme(s) et '. $nbr_femme->rowCount( ) .' femme(s). </p>';

        //Suppression:
        if( isset($_GET['action']) && $_GET['action'] == 'suppression'){

                $pdo->query("DELETE FROM annuaire WHERE id_annuaire = $_GET[id_annuaire]");
        }

        //Récupération des données:
        if( isset($_GET['action']) && $_GET['action'] == 'modification'){

                $r = $pdo->query("SELECT * FROM annuaire WHERE id_annuaire=$_GET[id_annuaire]");

                $membre = $r->fetch(PDO::FETCH_ASSOC);
        }
        //var_dump($membre);
        $id_annuaire = (isset($membre['id_annuaire']) ) ? $membre['id_annuaire'] : '';
        $nom = (isset($membre['nom']) ) ? $membre['nom'] : '';
        $prenom = (isset($membre['prenom']) ) ? $membre['prenom'] : '';
        $telephone = (isset($membre['telephone']) ) ? $membre['telephone'] : '';
        $profession = (isset($membre['profession']) ) ? $membre['profession'] : '';
        $ville = (isset($membre['ville']) ) ? $membre['ville'] : '';
        $codepostal = (isset($membre['codepostal']) ) ? $membre['codepostal'] : '';
        $adresse = (isset($membre['adresse']) ) ? $membre['adresse'] : '';
        $date_de_naissance = (isset($membre['date_de_naissance']) ) ? $membre['date_de_naissance'] : '';
        $sexe = (isset($membre['sexe']) ) ? $membre['sexe'] : '';
        $description = (isset($membre['description']) ) ? $membre['description'] : '';

        //Modification:
        if( $_POST ){

                $pdo->query("UPDATE annuaire SET nom = '$_POST[nom]', prenom = '$_POST[prenom]',telephone = '$_POST[telephone]',profession = '$_POST[profession]',ville = '$_POST[ville]',codepostal = '$_POST[codepostal]',adresse = '$_POST[adresse]',date_de_naissance = '$_POST[date_de_naissance]',sexe = '$_POST[sexe]',description = '$_POST[description]' WHERE id_annuaire = '$_GET[id_annuaire]' ");

                header('location:affichage_annuaire.php');
        }


 ?>

 <form method="post">
         <label for="nom">Nom</label><br>
         <input type="text" name="nom" id="nom" value="<?php echo $nom ?>"><br><br>
         <label for="prenom">Prenom</label><br>
         <input type="text" name="prenom" id="prenom" value="<?php echo $prenom ?>"><br><br>
         <label for="telephone">Telephone</label><br>
         <input type="text" name="telephone" id="telephone" value="<?php echo $telephone ?>"><br><br>
         <label for="profession">Profession</label><br>
         <input type="text" name="profession" id="profession" value="<?php echo $profession ?>"><br><br>
         <label for="ville">Ville</label><br>
         <input type="text" name="ville" id="ville" value="<?php echo $ville ?>"><br><br>
         <label for="codepostal">Code postal</label><br>
         <input type="text" name="codepostal" id="codepostal" value="<?php echo $codepostal ?>"><br><br>
         <label for="adresse">Adresse</label><br>
         <input type="text" name="adresse" id="adresse" value="<?php echo $adresse ?>"><br><br>

         <label for="date_de_naissance">Date de naissance</label><br>
         <input type="date" name="date_de_naissance" id="date_de_naissance" value="<?php echo $date_de_naissance ?>">

         <label for="sexe">Sexe</label><br>
         <input type="radio" name="sexe" id="sexe" value="m" <?php if($sexe == 'm') echo ' checked'; ?>>Homme
         <input type="radio" name="sexe" id="sexe" value="f" <?php if($sexe == 'f')echo ' checked'; ?>>Femme<br><br>
         <label for="description">Description</label><br>
         <input type="text" name="description" id="description" value="<?php echo $description ?>"><br><br>

         <input type="submit" name="inscription" value="Inscription">
 </form>

<?php

 //affichage du nombre d'hommes et de femmes

         $r = execute_requete("SELECT * FROM annuaire WHERE sexe='m'");
         $nombre_homme = $r->rowCount();

         $r = execute_requete("SELECT * FROM annuaire WHERE sexe='f'");
         $nombre_femme = $r->rowCount();

         $content .= "le nombre d'homme est $nombre_homme et le nombre de femme est $nombre_femme.<br><br><br>";


         //ou on peut faire aussi/ variation:
         $nbr_homme = $pdo->query("SELECT * FROM annuaire WHERE sexe='m'");
         $nbr_femme = $pdo->query("SELECT * FROM annuaire WHERE sexe='f'");
         $content .= 'Deuxième formule: le nombre d\'homme est ' . $nbr_homme->rowCount() . ' et le nombre de femme est ' . $nbr_femme->rowCount();

 ?>
