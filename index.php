<?php

//Yanisse FERHAOUI n° étudiant : 11909519
// Noureddine SIDKI n° étudiant : 12008210

// index.php fait office de controleur frontal
session_start(); // démarre ou reprend une session
ini_set('display_errors', 1); // affiche les erreurs (au cas où)
ini_set('display_startup_errors', 1); // affiche les erreurs (au cas où)
error_reporting(E_ALL); // affiche les erreurs (au cas où)
if(file_exists('../private/config-bd.php'))  // vous n'avez pas besoin des lignes 7 à 9
	require('../private/config-bd.php'); // inclut un fichier de config "privé"
else
	require('inc/config-bd.php'); // vous pouvez inclure directement ce fichier de config (sans le if ... else précédent)
require('modele/modele.php'); // inclut le fichier modele
require('inc/includes.php'); // inclut des constantes et fonctions du site (nom, slogan)
require('inc/routes.php'); // fichiers de routes

$connexion = getConnexionBD(); // connexion à la BD
?>


<html>
	
  <head>
  <link rel="stylesheet" href="css/style.css">
  <title>Jardynastie</title>
  <link rel="shortcut icon" type="image/x-icon" href="img/logo.png" /> <!-- On integre un logo dans le site -->
  </head>
  
  <body>
  <audio loop src="music/223_Salt_Marsh.mp3" controls> <!-- On integre un audio dans le site -->
	  Si ce message apparait votre navigateur ne supporte pas l'audio.
  </audio>
	  <?php include('static/header.php'); ?> <!-- On integre le header dans le site -->
	  <?php include('static/menu.php'); ?> <!-- On integre un menu dans le site -->
	  <?php include('static/aside.php'); ?> <!-- On integre un bloc d'info (celui situé à droite) dans le site -->
	  <?php
		$controleur = 'controleurAccueil'; // par défaut, on charge accueil.php
		$vue = 'vueAccueil'; // par défaut, on charge accueil.php
		if(isset($_GET['page'])) {
			$nomPage = $_GET['page'];
			if(isset($routes[$nomPage])) { // si la page existe dans le tableau des routes, on la charge
				$controleur = $routes[$nomPage]['controleur'];
				$vue = $routes[$nomPage]['vue'];
			}
		}
		include('controleurs/' . $controleur . '.php');
		include('vues/' . $vue . '.php');
		?>
	  <?php include('static/footer.php'); ?> <!-- On integre le footer dans le site -->
  </body>
  
</html>
