<?php

	$titre = "Détails de Representation";
	include('entete.php');

	// construction de la requete
	$requete = ("
		SELECT nomS
		FROM theatre.LesSpectacles
	");

	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

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
			echo "<p class=\"erreur\"><b>Aucun spectacle dans la base de donnée</b></p>" ;

		}
		else {

			// on affiche le formulaire de sélection
			echo ("
				<form action=\"DetailsRepresentation_action.php\" method=\"post\">
					<label for=\"sel_nomS\">Sélectionnez un spectacle :</label>
					<select id=\"sel_nomS\" name=\"nomS\">
			");

			// création des options
			do {

				$nomS = oci_result($curseur, 1);
				echo ("<option value=\"$nomS\">$nomS</option>");

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