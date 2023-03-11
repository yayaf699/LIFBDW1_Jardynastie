<?php if(isset($message)) { ?>
	<p style="background-color: yellow;"><?= $message ?></p>
<?php } ?>

<div >

<form method="post" action="#">	<!-- On crée un formulaire pour connaitre les infos de la Variété qu'on doit crée (il y'a plusieurs contraintes dans les input) -->
	
	<label for="nom">Nom : </label>
	<input required type="text" value = "nom" id="nom"  name = "nom" /> <br /> <!-- Required permet d'obliger l'utilisateur à remplir la case --> 
	<label for="annee">Année : </label>
	<input type="number" value = 2021 min=0 id="annee" name = "annee" /> <br />	
	<label for="precocite">Precocité (en jours) : </label>
	<input type="number" value = 1 min=0 name = "precocite" /> <br />
	<label for="semis">Conseil semage : </label>
	<textarea name = "semis" id="semis">Bien repartir les graines</textarea> <br />
	<label for="plantation">Conseil plantation : </label>
	<textarea name = "plantation" id="plantation">Prevoir une pelle</textarea> <br />
	<label for="entretien">Conseil entretien : </label>
	<textarea name = "entretien" id="entretien">Arroser quotidiennement</textarea> <br />
	<label for="recolte">Conseil recolte : </label>
	<textarea name = "recolte" id="recolte">Eviter les gestes brusques</textarea> <br />
	<label for="nbjour" min=0 >Nombre de jour de levée : </label>
	<input type="number" value = 1 min = 0 id="nbjour" name = "nbjour" /> <br /></br>
	<label for="periodemiseenplace">Periode de mise en place : </label>
	<input type="text" value = "Printemps" id="periodemiseenplace" name = "periodemiseenplace" /> <br /></br>
	<label for="perioderecolte">Periode de recolte : </label>
	<input type="text" value = "Automne" id="perioderecolte" name = "perioderecolte" /> <br />
	<label for="commentaire">Commentaire : </label>
	<textarea name = "commentaire"  id="commentaire" placeholder="Entrer un commentaire : "></textarea> <br />
	<input type="submit" name="boutonConfirmer" value="Ajouter"/> 
	
</form>
<br /></br>
</div>

