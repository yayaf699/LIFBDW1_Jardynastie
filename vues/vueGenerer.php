<?php if(isset($message)) { ?>
	<p style="background-color: red;"><?= $message ?></p>
<?php } ?>

<div>

<form method="post" action="#">	<!-- On crée un formulaire pour connaitre les infos de la parcelle à generer(il y'a plusieurs contraintes dans les input) -->
	
	<label for="nomjardin">Entrer le nom de votre jardin : </label>
	<input required type="text" id="nomjardin"  name = "nomjardin" /> <br /> <br /> <!-- Required permet d'obliger l'utilisateur à remplir la case --> 
	<label for="minimum">Entrer le nombre minimum de rang : </label>
	<input required type="number" min = 0 id="minimum"  name = "minimum" /> <br /> <br />
	<label for="maximum">Entrer le nombre maximum de rang :  </label>
	<input required type="number" min = 0 id="maximum" name = "maximum" /> <br /> <br />	 
	<label for="pourcentage_culture">Entrer le pourcentage de rangs occupés par des cultures : </label>
	<input required type="number" min = 0 max =  100 id="pourcentage_culture" name = "pourcentage_culture" /> <br /> <br />
	<label for="pourcentage_plantes_indesirable">Entrer le pourcentage de rangs occupés par des plantes indésirables : </label>
	<input required type="number"  min = 0 max =  100 id="pourcentage_plantes_indesirable" name = "pourcentage_plantes_indesirable" /> <br /> <br /> <br />
	<input type="submit" name="boutonConfirmer" value="Generer"/> 
	
</form>
</div>

<br><br><br>

<?php
if(isset($TableauNom) && isset($nbrangform)){
	echo '<table id="tablegen"> <th>';
	$tmp = 0; // $tmp servira à chercher le nom du contenue du prochain rang dans $TableauNom
	for($k = 0; $k < sqrt($nbrangform) ; $k=$k+1)  // Permet d'avoir un affichage mieux repartie
	{
		echo '<tr>';
		for ($m = 0; $m < sqrt($nbrangform) ; $m=$m+1) // pareil ^^^^^^
		{
			if($tmp > $nbrangform-1) //on sort dès qu'on a traiter tout les rangs
			{
				exit();
			}
			if($TableauNom[$tmp]=='vide') // si le rang est vide on affiche uniquement l'image d'un rang vide
			{
				echo '<td id="tdgen" class="tooltip"> <img  class="tooltip" id="imgplante" src="img/vide.png"></img> </td>' ;
			}
			elseif( countInstancesWhere($connexion, "VARIÉTÉ","nomv",$TableauNom[$tmp])!=0) // si le nom du contenue du prochain rang est une variété 
			{
				$i = random_int(1,24); //on choisi un nombre entre 1 et 24 car on a que 25 images pour les variétés
				echo '<td  id="tdgen" class="tooltip"> <img  class="tooltip" id="imgplante" src="img/Variete/'. $i .'.png"></img>' ; // on choisi l'image (dans le repertoire de variete) en fonction du $i aléatoire 
				$tab = GetInstancesWhere($connexion, "VARIÉTÉ","nomv",$TableauNom[$tmp]); //on recupere toutes les infos de la variétés à inserer dans le rang
				foreach ($tab as $ligne) // ceci est un tableau qui affichera les infos du rang lorsque la souris passe dessus
				{
					echo '<h2 class="tooltiptext">' .
				    'Nom: ' . $ligne['nomv'] . '<br />' .
					'Année: ' . $ligne['annéev'] . '<br />' .
					'Précocité: ' . $ligne['précocité'] . '<br />' . 
					'Semis: ' . $ligne['semis'] . '<br />' . 
					'Plantation: ' . $ligne['plantation'] . '<br />' .
					'Entretien: ' . $ligne['entretien'] . '<br />' . 
					'Recolte: ' . $ligne['récolte'] . '<br />' . 
					'Nb jours lever: ' . $ligne['nbjourslever'] . '<br />' .
					'Periode mise en place: ' . $ligne['périodemiseenplace'] . '<br />' . 
					'Periode recolte: ' . $ligne['périoderécolte'] . '<br />' . 
					'Commentaire: ' . $ligne['commentaire']  . '<br />' . 
					'</h2> </td>';
				}
			}
			else // si le nom du contenue du prochain rang est une plante 
			{
				$i = random_int(1,23); //on choisi un nombre entre 1 et 23 car on a que 24 images pour les plantes
				echo '<td id="tdgen" class="tooltip"> <img  class="tooltip" id="imgplante" src="img/Plante/'. $i .'.png"></img>' ; // on choisi l'image (dans le repertoire de plante) en fonction du $i aléatoire 
				$tab = GetInstancesWhere($connexion, "PLANTE","nomplante",$TableauNom[$tmp]); //on recupere toutes les infos de la plante à inserer dans le rang
				foreach ($tab as $ligne) // ceci est un tableau qui affichera les infos du rang lorsque la souris passe dessus
				{
					echo '<h2 class="tooltiptext">' .
				    'Nom: ' . $ligne['nomplante'] . '<br />' .
					'Nom latin: ' . $ligne['nomlatin'] . '<br />' .
					'Catégorie: ' . $ligne['categorie'] . '<br />' . 
					'Type: ' . $ligne['typeplante'] . '<br />' . 
					'Sous-type: ' . $ligne['soustype'] . '<br />' .
					'Bonus: ' . $ligne['bonus'] . '<br />' . 
					'Malus: ' . $ligne['malus'] . '<br />' .  
					'</h2> </td>';
				}
			}
		    $tmp = $tmp + 1;
		}
		echo '</tr>' ;
    }
	echo '</th> </table>';
	
}


?>
