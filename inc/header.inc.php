<?php require_once('init.inc.php'); ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Accueil</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/shop-homepage.css" rel="stylesheet">
    <link href="assets/css/style-perso.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    
  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">Lokisalle</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>qui_sommes_nous.php">Qui sommes nous?</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>contact.php">Contact</a>
              </li>
              
              <!-- DEBUT PHP -->
              <?php if(adminConnect() ) : ?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown" href="<?= URL ?>admin/"> BackOffice</a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= URL ?>admin/gestion_salle.php">Gestion des Salles</a>
                    <a class="dropdown-item" href="<?= URL ?>admin/gestion_produit.php">Gestion des Produits</a>
                    <a class="dropdown-item" href="<?= URL ?>admin/gestion_membre.php">Gestion des Membres</a>
                    <a class="dropdown-item" href="<?= URL ?>admin/gestion_commande.php">Gestion des Commandes</a>
                    <a class="dropdown-item" href="<?= URL ?>admin/gestion_avis.php">Gestion des Avis</a>
                    <a class="dropdown-item" href="<?= URL ?>admin/statistique.php">Statistiques</a>
                  </div>
                </li>
              <?php endif; ?>
              <!-- FIN PHP -->
              
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                <i class="fas fa-user"></i> Espace Membre
              </a>
              <div class="dropdown-menu">
              
              <!-- DEBUT PHP -->
              <?php if( userConnect() ) : ?>
                <a class="dropdown-item" href="<?= URL ?>profil.php">Profil</a>
                <a class="dropdown-item" href="<?= URL ?>connexion.php?action=deconnexion">Deconnexion</a>
              <?php else : ?>
                <a class="dropdown-item" href="<?= URL ?>inscription.php">Inscription</a>
                <a class="dropdown-item" href="<?= URL ?>connexion.php">Connexion</a>
              <?php endif; ?>
              <!-- FIN PHP -->
              
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Fin de la Navigation -->    
    <!-- Page Content -->
    <div class="container">
