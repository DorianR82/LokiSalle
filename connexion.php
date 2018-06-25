<?php require_once('inc/header.inc.php'); ?>
<?php
if(isset($_GET['action']) && $_GET['action'] == 'deconnexion'){
        session_destroy();
}
if(userConnect()){
        header('location:profil.php');
        exit();
}
if($_POST){
        debug($_POST);
        $r = execute_requete("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]' ");
        if($r->rowCount()>=1){
                $membre = $r->fetch(PDO::FETCH_ASSOC);
                if(password_verify($_POST['mdp'], $membre['mdp'])){
                        $_SESSION['membre']['id_membre'] = $membre['id_membre'];
                        $_SESSION['membre']['pseudo'] = $membre['pseudo'];
                        $_SESSION['membre']['nom'] = $membre['nom'];
                        $_SESSION['membre']['prenom'] = $membre['prenom'];
                        $_SESSION['membre']['email'] = $membre['email'];
                        $_SESSION['membre']['civilite'] = $membre['civilite'];
                        $_SESSION['membre']['statut'] = $membre['statut'];
                        $_SESSION['membre']['date_inscription'] = $membre['date_inscription'];
                        header('location:profil.php');
                }else{
                        $content .= '<div class="alert alert-danger" role="alert">Erreur de mot de passe</div>';
                }
        }else{
                $content .= '<div class="alert alert-danger" role="alert">Pseudonyme inexistant</div>';
        }
}
?>

<?= $content ?>
<div class="row mt-5 mb-5" >
        <div class="col-md-4 offset-md-4 mt-5 px-5 py-5" style="background:lightgrey; border-radius:10px; box-shadow: 2px 2px 3px grey;">
<form method="post">
        <label for="pseudo">Pseudo</label><br>
        <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Votre pseudo"><br><br>

        <label for="mdp">Mot de passe</label><br>
        <input type="text" class="form-control" id="mdp" name="mdp" placeholder="Votre mot de passe"><br><br>

        <input type="submit" class="btn btn-default" style="background:white;">
</form>
</div>
</div>
<?php require_once('inc/footer.inc.php'); ?>
