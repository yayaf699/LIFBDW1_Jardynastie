<?php if(isset($message)) { ?>
	<p style="background-color: red;"><?= $message ?></p>
<?php } ?>


<form method="post" action="#">	 <!-- On crée un formulaire pour connaitre ce qu'il faut afficher -->
	<label for="idChamp">Afficher les</label>
	<select name="champRech" id="idChamp">
		<option value=""></option>
		<option value="variétés" >variétés</option>
		<option value="plantes" >plantes</option>
		<option value="types" >types</option>
	</select>
	<input type="submit" name="boutonValider" value="Afficher"/>
	
</form>


<?php
if(isset($choix)){
	if($choix == "variétés")
	{
		$alldonnees = GetInstances($connexion, "VARIÉTÉ"); // On recupere toutes les données des variétés
		echo '<table id="tableafficher">'; // On crée la table et plus bas la ligne des noms colonnes
		echo '<TR> 
		<TD id="tdafficher" > Nom </TD>
		<TD id="tdafficher"> Année </TD>
		<TD id="tdafficher"> Précocité </TD>
		<TD id="tdafficher"> Semis </TD>
		<TD id="tdafficher"> Plantation </TD>
		<TD id="tdafficher"> Entretien </TD>
		<TD id="tdafficher"> Recolte </TD> 
		<TD id="tdafficher"> Nb jours lever </TD>
		<TD id="tdafficher"> Periode mise en place </TD> 
		<TD id="tdafficher"> Periode recolte </TD> 
		<TD id="tdafficher"> Commentaire </TD>
		</TR>';
		foreach ($alldonnees as $ligne) // Pour chaque variété on affichera une par une les information (dans une ligne de tableau)
				{
					echo '<TR>
			        <TD id="tdafficher">' . $ligne['nomv'] . '</TD>
					<TD id="tdafficher">' . $ligne['annéev'] . '</TD>
					<TD id="tdafficher">' . $ligne['précocité'] . '</TD>
					<TD id="tdafficher">' . $ligne['semis'] . '</TD>
					<TD id="tdafficher">' . $ligne['plantation'] . '</TD>
					<TD id="tdafficher">' . $ligne['entretien'] . '</TD> 
					<TD id="tdafficher">' . $ligne['récolte'] . '</TD>
					<TD id="tdafficher">' . $ligne['nbjourslever'] . '</TD>
					<TD id="tdafficher">' . $ligne['périodemiseenplace'] . '</TD>
					<TD id="tdafficher">' . $ligne['périoderécolte'] . '</TD>
					<TD id="tdafficher">' . $ligne['commentaire']  . '</TD>
		            </TR>';
				}
		echo '</table> <br />';
	}
	elseif($choix == "plantes")
	{
		$alldonnees = GetInstances($connexion, "PLANTE"); // On recupere toutes les données des plantes
		echo '<table id="tableafficher">'; // On crée la table et plus bas la ligne des noms colonnes
		echo '<TR> 
		<TD id="tdafficher"> Nom </TD>
		<TD id="tdafficher"> Nom latin </TD>
		<TD id="tdafficher"> Catégorie </TD>
		<TD id="tdafficher"> Type </TD>
		<TD id="tdafficher"> Sous-type </TD>
		<TD id="tdafficher"> Bonus </TD>
		<TD id="tdafficher"> Malus </TD> 
		</TR>';
		foreach ($alldonnees as $ligne)  // Pour chaque plantes on affichera une par une les information (dans une ligne de tableau)
				{
					echo '<TR>
			        <TD id="tdafficher">' . $ligne['nomplante'] . '</TD>
					<TD id="tdafficher">' . $ligne['nomlatin'] . '</TD>
					<TD id="tdafficher">' . $ligne['categorie'] . '</TD>
					<TD id="tdafficher">' . $ligne['typeplante'] . '</TD>
					<TD id="tdafficher">' . $ligne['soustype'] . '</TD>
					<TD id="tdafficher">' . $ligne['bonus'] . '</TD> 
					<TD id="tdafficher">' . $ligne['malus'] . '</TD>
		            </TR>';
				}
		echo '</table> <br />';
	}
	elseif($choix == "types")
	{
		$alldonnees = GetAttributDISTINCT($connexion, "PLANTE","typeplante"); // On recupere toutes les noms de type de plantes DIFFERENTS
		echo '<table id="tableafficher">'; // Initialise le noms de colonnes du tableau
		echo '<TR> 
		<TD id="tdafficher"> Type </TD> 
		</TR>';
		foreach ($alldonnees as $ligne) // Pour chaque type de plante on affiche son nom
				{
					echo '<TR>
					<TD id="tdafficher">' . $ligne['typeplante'] . '</TD>
		            </TR>';
				}
		echo '</table> <br />';
	}

}
echo '</br></br></br>';
?>

