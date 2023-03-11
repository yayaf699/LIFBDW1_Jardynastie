<?php 

if(isset($_POST['boutonConfirmer'])) 
{
	
	if($_POST['minimum']>$_POST['maximum']) // On verifie si minimum est plus grand que maximum (qui poserait un probleme pour random_int)
	{
		$message = "ERREUR : Le minimum est plus grand que le maximum";
		return '';
	}
	if(($_POST['pourcentage_culture']+$_POST['pourcentage_plantes_indesirable'])>100) //On verifie si la somme des pourcentages > 100
	{
		$message = "ERREUR : La somme des pourcentages est plus grand que 100%" ;
		return '';
	}
	echo '<br />';
	$nbrangform = random_int($_POST['minimum'], $_POST['maximum']);
	$longueur = $nbrangform*15; // on calcule la longueur totale de la parcelle en supposant qu'un rang a une longueur de 15
	$largeur = $nbrangform*5; // on calcule la largeur totale de la parcelle en supposant qu'un rang a une largeur de 5
	$idJardin = countInstances($connexion,"JARDIN") + 1; // on initialise notre notre nouvelle idJardin à nombre de jardin actuel + 1
	$Newjardin = array($idJardin,$_POST['nomjardin'],$longueur,$largeur); // on reunit toutes les infos concernant notre nouveau jardin
	insertJardin($connexion, $Newjardin); // on insere dans notre BD le jardin
	
	$idParcelle = countInstances($connexion,"PARCELLE") + 1; // on initialise notre notre nouvelle idParcelle à nombre de parcelle actuel + 1
	$Newparcelle = array($idParcelle,$longueur,$largeur,$idJardin); // on reunit toutes les infos concernant notre nouveau jardin
    insertParcelle($connexion, $Newparcelle);  // on insere dans notre BD la parcelle
    
	for($i = 1; $i < $nbrangform+1 ; $i=$i+1)  //cette fonction permet de crée les rangs en  incrementant leur numéro de 1
	{
		$numrang = $i ;
		$Newrang = array($idParcelle,$numrang,0,0);
		insertRang($connexion, $Newrang); // on insere dans notre BD le rang
		
	}
	$nbChampCultivé = round((($nbrangform*$_POST['pourcentage_culture']) / 100),0, PHP_ROUND_HALF_DOWN); // on traite les pourcentages en fonction du nombre de rang et arrondit a la baisse le nombre de rang dans lequel il y'aura des cultures
	$VarieteChoisi = GenererNomRAND ($connexion,"VARIÉTÉ","nomv",$nbChampCultivé); // cette fonction retourne un nombre n nom de variété aléatoires
	$nbChampPlante = round((($nbrangform*$_POST['pourcentage_plantes_indesirable']) / 100),0, PHP_ROUND_HALF_UP); // pareil sauf que cette fois on arrondit à la hausse (on est obligé d'arrondir pour eviter un partage 50/50 sur un nombre de rang impair 
	$PlanteChoisi = GenererNomRAND ($connexion,"PLANTE","nomplante",$nbChampPlante); // cette fonction retourne un nombre n nom de plantes aléatoires
	$nbChampVide = $nbrangform - ($nbChampPlante+$nbChampCultivé); // le nombre de champs vide est le nombre totale de rang soustrait au nombre de rang de Plante et Variétés
	if($nbChampVide != 0)
	{
		$TabCaseVide = array();
	    for($n = 0; $n < $nbChampVide ; $n=$n+1) // on crée les rangs vides
	    {
			$TabCaseVide[$n] = 'vide';
	    }
	}
	else
	{
		$TabCaseVide = array();
	}
	echo '<br />' . '</br>' ;
	$TableauNom = array_merge($VarieteChoisi,$PlanteChoisi,$TabCaseVide); // on reunit toutes les noms du contenue de chaque rang de la parcelle 
	shuffle($TableauNom); // on melange afin de repartir les rangs plantes, cultures et vide et qu'ils ne se suivent pas
	$nbColonne = $nbrangform/2; // Permet d'avoir un affichage mieux repartie
	$nbLigne = $nbColonne ; // ^^^^
}
    ?>
