<?php 

// connexion à la BD, retourne un lien de connexion
function getConnexionBD() {
	$connexion = mysqli_connect(SERVEUR, UTILISATRICE, MOTDEPASSE, BDD);
	if (mysqli_connect_errno()) {
	    printf("Échec de la connexion : %s\n", mysqli_connect_error());
	    exit();
	}
	return $connexion;
}

// déconnexion de la BD
function deconnectBD($connexion) {
	mysqli_close($connexion);
}

function integration ($connexion) {
	$requete = "SELECT codeVariété,annéeEnregistrement,labelPrécocité,commentaire FROM dataset.DonneesFournies"; // recupere les données de variétés
	$res = mysqli_query($connexion, $requete);
	$alldonnees = mysqli_fetch_all($res, MYSQLI_ASSOC);
	foreach ($alldonnees as $ligne)
	{
		$banChars = array("~","!","%","^","&","(",")","-","{","}",".","'","`","\\"); // tableau qui contient les caractères interdit (qui pose probleme à la base de donnée ou au code de notre site)
		$nom = mysqli_real_escape_string($connexion,$ligne['codeVariété']);
		$nom = str_replace(" ", "_", $nom); // remplace les espace des noms de variétés par des '_'
		$nom = str_replace($banChars, "", $nom); // supprime les caractères interdit des noms de variétés
		if($nom=='') // si le nom de notre variété est NULL alors on la renomme NULL
		{
			$nom = "NULL";
			$nom = $nom . countInstancesWhereLike($connexion, "VARIÉTÉ","nomv",$nom); // si on a déja une variété qui n'a pas été nommé dans la base, alors on en crée une avec un numéro à la fin (1,2,3,4,5..)
     	}
		elseif(countInstancesWhereLike($connexion, "VARIÉTÉ","nomv",$nom)!=0) // le nom de cet variété est déja dans notre base de donnée
		{
			$nom = mysqli_real_escape_string($connexion,$nom . countInstancesWhereLike($connexion, "VARIÉTÉ","nomv",$nom)) ; // on l'ajoute mais avec un numéro à la fin alors on en crée une avec un numéro à la fin (1,2,3,4,5..) selon le nombre de variété déja rajouter avec le meme nom
     	}
     	else // le nom de cet variété n'est pas dans notre base de donnée
     	{
			$nom = mysqli_real_escape_string($connexion,$nom) ; // on ajoute tout simplement
		}
		if($ligne['annéeEnregistrement']=='') // si la date n'est pas défini
		{
			$annee = NULL; 
     	}
     	else
     	{
			$annee = mysqli_real_escape_string($connexion,$ligne['annéeEnregistrement']);
		}
		if($ligne['labelPrécocité']=='') // si la précocité n'est pas défini
		{
			$precocite = NULL;
     	}
     	else
     	{
			$precocite = mysqli_real_escape_string($connexion,$ligne['labelPrécocité']);
		}
		if($ligne['commentaire']=='') // si le commentaire n'est pas défini
		{
			$commentaire = NULL;
     	}
     	else
     	{
			$commentaire = mysqli_real_escape_string($connexion,$ligne['commentaire']);
		}
			
			$requete = "INSERT INTO VARIÉTÉ(nomv,annéeV,précocité,commentaire) 
	        VALUES ('$nom','$annee','$precocite','$commentaire')"; // On  ajoute les données traité dans notre base de donnée variété
	        $res = mysqli_query($connexion, $requete);
	        if($res == FALSE) 
	        {
				//echo "erreur";
				//echo $requete;
			}
			
		
	}
	$requete = "SELECT nomEspèce,nomEspèceLatin,type,sousType FROM dataset.DonneesFournies";
	$res = mysqli_query($connexion, $requete);
	$alldonnees = mysqli_fetch_all($res, MYSQLI_ASSOC);
	foreach ($alldonnees as $ligne)
	{
		$nom = mysqli_real_escape_string($connexion,$ligne['nomEspèce']);
		$nom = str_replace(" ", "_", $nom);
		$nom = str_replace($banChars, "", $nom);
		if($nom=='') // si le nom de notre plante est NULL alors on la renomme NULL
		{
			$nom = "NULL";
			$nom = $nom . countInstancesWhere($connexion, "PLANTE","nomplante",$nom);
     	}
     	else //  sinon si elle existe deja on rajoute un (1,2,3..) selon le nombre de plante du meme nom déja integrer
     	{
			$nom = mysqli_real_escape_string($connexion,$nom . countInstancesWhere($connexion, "PLANTE","nomplante",$nom));
		}
		if($ligne['nomEspèceLatin']=='')  // si le nom en latin de la plante n'est pas défini
		{
			$nomlatin = NULL; 
     	}
     	else
     	{
			$nomlatin = mysqli_real_escape_string($connexion,$ligne['nomEspèceLatin']);
		}
		if($ligne['type']=='') // si le type de la plante n'est pas défini
		{
			$type = NULL;
     	}
     	else
     	{
			$type = mysqli_real_escape_string($connexion,$ligne['type']);
		}
		if($ligne['sousType']=='') // si le sous type n'est pas défini
		{
			$soustype = NULL;
     	}
     	else
     	{
			$soustype = mysqli_real_escape_string($connexion,$ligne['sousType']);
		}
			
			$requete = "INSERT INTO PLANTE(nomPlante,nomlatin,typeplante,soustype) 
	        VALUES ('$nom','$nomlatin','$type','$soustype')";  // On  ajoute les données traité dans notre base de donnée plante
	        $res = mysqli_query($connexion, $requete);
	        if($res == FALSE) 
	        {
				//echo "erreur";
				//echo $requete;
			}
	}
	return ;
	//
}

function countTypePlante($connexion) // on compte tout simpement les types de plantes differents de notre base de donnée
{
	$requete = "SELECT COUNT(DISTINCT typeplante) AS nb FROM PLANTE ";
	$res = mysqli_query($connexion, $requete);
	if($res != FALSE) 
	{
		$row = mysqli_fetch_assoc($res);
		return $row['nb'];
	}
	return -1;  // valeur négative si erreur de requête (ex, $nomTable contient une valeur qui n'est pas une table)
}

// nombre d'instances d'une table $nomTable

	
function countInstancesWhere($connexion, $nomTable,$nomAttribut,$valAttribut) // compte le nombre d'instance avec un attribut donnée qui correspond à une chaine de caractère
{
	$requete = "SELECT COUNT(*) AS nb FROM $nomTable WHERE $nomAttribut = '$valAttribut'";
	$res = mysqli_query($connexion, $requete);
	//echo $requete;
	if($res != FALSE) 
	{
		$row = mysqli_fetch_assoc($res);
		return $row['nb'];
	}
	return -1;  // valeur négative si erreur de requête (ex, $nomTable contient une valeur qui n'est pas une table)
}

function countInstancesWhereLike($connexion, $nomTable,$nomAttribut,$valAttribut) // compte le nombre d'instance avec un attribut donnée qui commence par un chaine de caractère donnée
{
	$requete = "SELECT COUNT(*) AS nb FROM $nomTable WHERE $nomAttribut LIKE '$valAttribut%' ";
	$res = mysqli_query($connexion, $requete);
	//echo $requete;
	if($res != FALSE) 
	{
		$row = mysqli_fetch_assoc($res);
		return $row['nb'];
	}
	return -1;  // valeur négative si erreur de requête (ex, $nomTable contient une valeur qui n'est pas une table)
}


// nombre d'instances d'une table $nomTable

function countInstances($connexion, $nomTable) { // compte le nombre d'instance dans une table donnée
	$requete = "SELECT COUNT(*) AS nb FROM $nomTable";
	$res = mysqli_query($connexion, $requete);
	if($res != FALSE) {
		$row = mysqli_fetch_assoc($res);
		return $row['nb'];
	}
	return -1;  // valeur négative si erreur de requête (ex, $nomTable contient une valeur qui n'est pas une table)
}


function statistiques ($connexion) // retourne le nombre de rangs et l'id des 5 plus grandes parcelles pour remplire le aside
{
     $requete = "SELECT idParcelle,COUNT(*) AS nb FROM RANG GROUP BY idParcelle ORDER BY nb DESC LIMIT 5 ";
     $res = mysqli_query($connexion, $requete);
     $i=0;
     $row = array();
     while ($ligne = mysqli_fetch_array($res))
     {
		 $row[$i] = $ligne;
		 $i= $i+1;
	 }
	 if($res == FALSE) 
	        {
				//echo "erreur";
				//echo $requete;
			}
     return $row;
}

function GetAttributDISTINCT($connexion, $nomTable,$nomAttribut) { // retourne toutes les valeurs differentes d'un attribut donnée, d'une table chosi
	$requete = "SELECT DISTINCT $nomAttribut FROM $nomTable";
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	if($res == FALSE) 
	        {
				//echo "erreur";
				//echo $requete;
			}
	return $instances;
}
 
function GetAttributWhereAttribut($connexion, $nomTable,$nomAttribut,$nomAttribut2,$valAttribut) { // retourne toutes les valeurs d'un attribut donnée, d'une table chosi lorsque le 2nd attribut donnée est égale à la valeur donnée
	$requete = "SELECT $nomAttribut FROM $nomTable WHERE $nomAttribut2 = '$valAttribut'";
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	if($res == FALSE) 
	        {
				//echo "erreur";
				//echo $requete;
			}
	return $instances;
}

// retourne les instances d'une table $nomTable
function GetInstancesWhere($connexion, $nomTable,$nomAttribut,$valAttribut) { // retourne toutes les données d'une table lorsqu'un attribut précisé est égale à une valeur fournie
	$requete = "SELECT * FROM $nomTable WHERE $nomAttribut = '$valAttribut'";
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	if($res == FALSE) 
	        {
				//echo "erreur";
				//echo $requete;
			}
	return $instances;
}

function GetInstances($connexion, $nomTable) { // retourne simplement toutes les données d'une table fournie
	$requete = "SELECT * FROM $nomTable";
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	if($res == FALSE) 
	        {
				//echo "erreur";
				//echo $requete;
			}
	return $instances;
}


function insertVariete($connexion, $Newvariete) { // recoit toutes les informations concernant une variété, puis les met dans l'ordre pour les ajouter proprement dans la table Variété
	for($i = 0; $i < 11; $i++) 
	{
		$Newvariete[$i] = mysqli_real_escape_string($connexion, $Newvariete[$i]); 
	}
	$requete = "INSERT INTO VARIÉTÉ VALUES ('". $Newvariete[0] . "','". $Newvariete[1] . "','". $Newvariete[2] . "','". $Newvariete[3] . "','". $Newvariete[4] . "','". $Newvariete[5] . "','". $Newvariete[6] . "','". $Newvariete[7] . "','". $Newvariete[8] . "','". $Newvariete[9] . "','". $Newvariete[10] . "')";
	$res = mysqli_query($connexion, $requete); 
	if($res == FALSE) 
	        {
				//echo "erreur";
				//echo $requete;
			}
	return $res;
}

function 	insertJardin($connexion, $Newjardin){ // recoit toutes les informations concernant un Jardin, puis les met dans l'ordre pour les ajouter proprement dans la table Jardin
	for($i = 0; $i < 3; $i++) 
	{
		$Newjardin[$i] = mysqli_real_escape_string($connexion, $Newjardin[$i]);
	}
	$requete = "INSERT INTO JARDIN VALUES ('". $Newjardin[0] . "','". $Newjardin[1] . "','". $Newjardin[2] . "','". $Newjardin[3] . "')";
	$res = mysqli_query($connexion, $requete); 
	if($res == FALSE) 
	        {
				//echo "erreur";
				//echo $requete;
			}
	return $res;
}

function insertParcelle($connexion, $Newparcelle) { // recoit toutes les informations concernant une parcelle, puis les met dans l'ordre pour les ajouter proprement dans la table Parcelle
	for($i = 0; $i < 4; $i++) 
	{
	$Newparcelle[$i] = mysqli_real_escape_string($connexion, $Newparcelle[$i]); 
	}
	$requete = "INSERT INTO PARCELLE VALUES ('". $Newparcelle[0] . "',0,0,'". $Newparcelle[1] . "','". $Newparcelle[2] . "','". $Newparcelle[3] . "')";
	$res = mysqli_query($connexion, $requete); 
	if($res == FALSE) 
	        {
				//echo "erreur";
				//echo $requete;
			}
	return $res;
}

function 	insertRang($connexion, $Newrang){ // recoit toutes les informations concernant un rang, puis les met dans l'ordre pour les ajouter proprement dans la table Rang

	for($i = 0; $i < 4; $i++) 
	{
		$Newrang[$i] = mysqli_real_escape_string($connexion, $Newrang[$i]);
	}
	$requete = "INSERT INTO RANG VALUES ('". $Newrang[0] . "','". $Newrang[1] . "','". $Newrang[2] . "','". $Newrang[3] . "')";
	$res = mysqli_query($connexion, $requete); 
	if($res == FALSE) 
	        {
				//echo "erreur";
				//echo $requete;
			}
	return $res;
}

function GenererNomRAND ($connexion,$nomtable,$nomAttribut,$nbChamp) // elle permet de tirer aléatoirement $nbChamp noms différents, on ne peut s'occuper que d'une table à la fois donc si on veut les differents noms de plantes et puis les differents noms de variétés ont doit executer 2 fois la fonction en sachant $nbChamps est égale au nombre de rang ou il y'a uniquement des plantes ou bien ou il y'a uniquement des variétés
{
	$NomChoisi = array(); // on initialise le tableau réponse
	for($i=0;$i<$nbChamp;$i=$i+1)
	{
		$numRand = random_int(0,(countInstances($connexion,$nomtable)-1)); // on genere aléatoirement un numéro qui se situe entre 0 et le nombre d'instance -1 de la table dont on veut chercher le contenue de nos rangs à remplir (ex : entre 0 et (8806-1) si on veut un nom de variété aléatoire)
		$requete = "SELECT $nomAttribut FROM $nomtable LIMIT 1 OFFSET $numRand"; // on utilise le nombre tiré aléatoirement pour exectuer le paramètre "OFFSET" qui permettra de sauter $numRand cases dans la table concerné afin de nous donner un nom aléatoire
		//echo $requete;
		$res = mysqli_query($connexion, $requete);
		$row = mysqli_fetch_array($res);
		$NomChoisi[$i] = $row[0]; //on rempli le tableau reponse avec les noms de Plante ou variété (pas les deux en meme temps) tiré aléatoirement 
	}
	return $NomChoisi; // on renvoie ce meme tableau réponse
}

?>
