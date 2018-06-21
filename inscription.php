<?php require_once('inc/header.inc.php'); ?>
<?php

if( userConnect() ){
        header('location:profil.php');
        exit();
}

if($_POST){
        $erreur = '';
        if( iconv_strlen($_POST['pseudo']) <= 3 || iconv_strlen($_POST['pseudo']) > 20  ){

                $erreur .= '<div class="alert alert-danger" role="alert">Erreur taille pseudo</div>';
        }
        $r = execute_requete("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]' ");
        if( $r->rowCount() >= 1){

                $erreur .= '<div class="alert alert-danger" role="alert">Pseudo indisponible</div>';
        }
        foreach($_POST as $indice => $valeur){

                $_POST[$indice] = addslashes($valeur);
        }
        $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
        if( empty($erreur) ){
                execute_requete(
                    "INSERT INTO membre(pseudo,mdp,nom,prenom,email,civilite,statut,date_inscription)
                    VALUE('$_POST[pseudo]','$_POST[mdp]','$_POST[nom]','$_POST[prenom]','$_POST[email]','$_POST[civilite]',0,NOW())");

                $content .= '<div class="alert alert-success" role="alert">Inscription validée !<a href="'.URL.'connexion.php">Cliquez ici pour vous connectez</a> </div>';
                var_dump($_POST);
        }
        $content .= $erreur;
}
?>

<?= $content ?>
<div class="row mt-5 mb-5" style="background:lightgrey; border-radius:10px; box-shadow: 2px 2px 3px grey;">
        <div class="col-md-10 offset-md-1 mt-5">
        <form method="post">
                <label for="pseudo">Pseudo</label><br>
                <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Votre pseudo"><br>

                <label for="mdp">Mot de passe</label><br>
                <input type="text" name="mdp" id="mdp" class="form-control" placeholder="Votre mot de passe"><br>

                <label for="nom">Nom</label><br>
                <input type="text" name="nom" id="nom" class="form-control" placeholder="Votre nom"><br>

                <label for="prenom">Prenom</label><br>
                <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Votre prénom"><br>

                <label for="email">Email</label><br>
                <input type="text" name="email" id="email" class="form-control" placeholder="Votre email"><br>

                <label for="sexe">Sexe</label><br>
                <input type="radio" name="civilite" id="sexe" value="M" checked> Homme<br>
                <input type="radio" name="civilite" id="sexe" value="F"> Femme<br><br>

                <input type="submit" class="btn btn-default mb-5" style="background:white;">
        </form>
        </div>
</div>

<?php require_once('inc/footer.inc.php'); ?>
