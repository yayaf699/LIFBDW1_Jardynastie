<?php

/*
** Il est possible d'automatiser le routing, notamment en cherchant directement le fichier controleur et le fichier vue.
** ex, pour page=afficher : verification de l'existence des fichiers controleurs/controleurAfficher.php et vues/vueAfficher.php
** Cela impose un nommage strict des fichiers.
*/

$routes = array(
	'accueil' => array('controleur' => 'controleurAccueil', 'vue' => 'vueAccueil'),
	'afficher' => array('controleur' => 'controleurAfficher', 'vue' => 'vueAfficher'),
	'ajouter' => array('controleur' => 'controleurAjouterVariete', 'vue' => 'vueAjouterVariete'),
	'generer' => array('controleur' => 'controleurGenerer', 'vue' => 'vueGenerer'),
	'integrer' => array('controleur' => 'controleurIntegrer', 'vue' => 'vueIntegrer')
	);

?>
