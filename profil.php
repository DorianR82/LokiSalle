<?php require_once('inc/header.inc.php'); ?>
<?php
if( !userConnect() ){
        header('location:connexion.php');
        exit();
}
if( adminConnect() ){
        $content .= '<p>Statut : Administrateur ';
}
?>
<h1>Bonjour <?=$_SESSION['membre']['pseudo']?></h1>

<p>Voici vos informations :</p>
<?= $content?>
<p>Nom : <?=$_SESSION['membre']['nom']?></p>
<p>Prénom : <?=$_SESSION['membre']['prenom']?></p>
<p>Email : <?=$_SESSION['membre']['email']?></p>
<p>Inscript depuis : <?=$_SESSION['membre']['date_inscription']?><p>
<?php require_once('inc/footer.inc.php'); ?>