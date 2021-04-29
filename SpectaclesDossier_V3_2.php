<?php

	// récupération de la catégorie
	$categorie = $_POST['categorie'];

	//
	$titre = 'Liste des places correspondant a la catéegorie et au numéero de dossier séelectionnées';
	include('entete.php');
   
  // construction de la requete
   $requete = ("
		SELECT distinct nomC 
    FROM theatre.leszones natural join theatre.lesplaces natural join theatre.lestickets
		WHERE noDossier=:n
	");
   // analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;
 
   	// affectation de la variable
    oci_bind_by_name ($curseur,':n', $categorie);

	// execution de la requete
	$ok = @oci_execute ($curseur) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {

		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";

	}
	else {

		// oci_execute a réussi, on fetch sur le premier résultat
		$res = oci_fetch ($curseur);

		if (!$res) {

			// il n'y a aucun résultat
			echo "<p class=\"erreur\"><b>Aucune categorie dans la base de donnée pour le dossier numero $categorie </b></p>" ;

		}
		else {

			// on affiche le formulaire de sélection
			echo ("
				<form method=\"post\" action=\"SpectaclesDossier_v3_action.php?noDossier=$categorie\">
        
					
          <label for=\"inp_categorie\">Sélectionnez une categorie pour NoDossier: $categorie :</label>
          <select id=\"inp_categorie\" name=\"categorie\">
			");

			// création des options
			do {

				$nomC = oci_result($curseur, 1);
        	echo ("<option value=\"$nomC\">$nomC</option>");

			} while ($res = oci_fetch ($curseur));

			echo ("
          </select>
					<br /><br />
					<input type=\"submit\" value=\"Valider\" />
					<input type=\"reset\" value=\"Annuler\" />
				</form>
			");

		}

	}

	// on libère le curseur
	oci_free_statement($curseur);
  
  
  
  include('pied.php');

?>
