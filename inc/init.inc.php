<?php
//---------------------------
//Ouverture de session
session_start();
//---------------------------
//Connexion à la base de données:
$pdo = new PDO('mysql:host=localhost;dbname=lokisalle', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') );
//---------------------------
//Définition de constantes:
define('URL','http://localhost/lokisalle/');
//---------------------------
//Déclaration d'une variable:
$content = '';
//---------------------------
//Inclusion des fonctions:
require_once('fonction.inc.php');
?>
