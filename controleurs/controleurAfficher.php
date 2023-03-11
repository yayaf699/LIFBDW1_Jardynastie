<?php 

// recupération des variétés et affiche un message si aucune variété n'exite
$varietes = getInstances($connexion, "VARIÉTÉ");
if($varietes == null || count($varietes) == 0) {
	$message .= "Aucune variété n'a été trouvée dans la base de données !";
}

// recupération des plantes et affiche un message si aucune plante n'exite
$plantes = getInstances($connexion, "PLANTE");
if($plantes == null || count($plantes) == 0) {
	$message .= "Aucune plante n'a été trouvée dans la base de données !";
}
if(isset($_POST['boutonValider'])) {
	$choix = $_POST['champRech'];
	}
?>
