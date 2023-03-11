<?php 


if(isset($_POST['boutonConfirmer'])) 
{
	if(countInstancesWhere($connexion, "VARIÉTÉ","nomv",$_POST['nom'])==0) // on verifie si le nom existe deja
	{
		$Newvariete = array($_POST['nom'],$_POST['annee'],$_POST['precocite'],$_POST['semis'],$_POST['plantation'],$_POST['entretien'],$_POST['recolte'],$_POST['nbjour'],$_POST['periodemiseenplace'],$_POST['perioderecolte'],$_POST['commentaire']);
        insertVariete($connexion, $Newvariete); // si le nom existe pas on crée la variété
        $message = "La variété à bien été ajoutée" ;
	}
	else
	{
		$message = "ERREUR : Une variété possedant le même nom existe déja" ; // sinon on retourne un message d'erreur
	}
}
?>

