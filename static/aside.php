<aside> <!-- contiendra nos statistiques -->
     <h1 id="center">Statistiques</h1>
     <h3>TOP 5 des parcelles avec le plus de rang :</h3>
     
     <?php 
     $row = statistiques($connexion); // renvoie les idParcelle des 5 parcelles contenant le plus de rangs
     for($i=0;$i<5;$i=$i+1)
     {
          $j = $i+1;
		 $nomjardin = GetAttributWhereAttribut($connexion, "PARCELLE","idjardin","idParcelle",$row[$i]['idParcelle']); // grâce à l'id de parcelle on obtient  l'id du jardin 
		 $nomjardin = GetAttributWhereAttribut($connexion, "JARDIN","nom","idjardin",$nomjardin[0]['idjardin']); // grâce à l'id de jardin on obtient le nom du jardin
		 echo  $j . "." . ' Jardin "' . $nomjardin[0]['nom'] . '" parcelle N°' . $row[$i]['idParcelle'] . ' avec ' . $row[$i]['nb'] . ' rangs </br>'; // on affiche le nom des jardins qui possèdent les parcelles avec le plus de rangs ainisi que le numero de la parcelle concerné et enfin le nombre de rangs de cette parcelle 
	 }
     ?>
     
     <h3 >Il y'a actuellement :</h3>
     <?php 
     $nbTypePlante = countTypePlante($connexion);
     echo countInstances($connexion,"VARIÉTÉ") . ' variétés <br /> ' ; // compte le nombre de variétés
     echo countInstances($connexion,"PLANTE") . ' plantes <br />  ' ; // compte le nombre de plantes
     echo $nbTypePlante . ' types de plantes  <br /> ' ; // compte le nombre de type de plantes differents
     echo '<b>' . countInstances($connexion,"PARCELLE") . ' différentes parcelles</b>' ; // compte le nombre de parcelle
     ?>
     
<br /> 
<br /> 
<br /> 
<br /> 

</aside>
