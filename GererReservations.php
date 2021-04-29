<?php

	$titre = 'Gerer les Reservations';
	include('entete.php');
   echo "<table><tr><th>Creer nouveau dossier:</th></tr>" ;
     echo ("
 
		    <form action=\"ReservationsCreationDossier.php\" method=\"POST\">
			      <input type=\"submit\" name=\"noDossier\" value=\"Generer nouveau dossier client\" />
		</form>
	"); 
  echo "</table>";
  echo "<table><tr><th>Modifier dossier: ajouter/supprimer/modifier les tickets du dossier</th></tr>" ;
 $requete = ("
		SELECT nodossier
		FROM lesdossiers
    ORDER BY nodossier
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
			echo "<p class=\"erreur\"><b>Aucun numero de dossier dans la base de donnée</b></p>" ;

		}
		else {
			// on affiche le formulaire de sélection
			echo ("
				<form action=\"reservationmodifficationdossier.php\" method=\"post\">
					<label for=\"inp_categorie\">Sélectionnez un numero de dossier :</label>
          <select id=\"inp_categorie\" name=\"categorie\">
			");

			// création des options
			do {

				  $nodossier = oci_result($curseur, 1);
        	echo ("<option value=\"$nodossier\">$nodossier</option>");

			} while ($res = oci_fetch ($curseur));
     
			echo ("
          </select>
           <br /><br />
					<input type=\"submit\" value=\"modifier le dossier\" />
					<input type=\"reset\" value=\"Annuler\" />
				</form>
			");

		}

	}

	// on libère le curseur
	oci_free_statement($curseur);
  echo "</table>";
  
  echo "<table><tr><th>Supprimer dossier</th></tr>" ;
 $requete = ("
		SELECT nodossier
		FROM lesdossiers
    ORDER BY nodossier
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
			echo "<p class=\"erreur\"><b>Aucun numero de dossier dans la base de donnée</b></p>" ;

		}
		else {
			// on affiche le formulaire de sélection
			echo ("
				<form action=\"reservationsuppressiondossier.php\" method=\"post\">
					<label for=\"inp_categorie\">Sélectionnez un numero de dossier :</label>
          <select id=\"inp_categorie\" name=\"categorie\">
			");

			// création des options
			do {

				  $nodossier = oci_result($curseur, 1);
        	echo ("<option value=\"$nodossier\">$nodossier</option>");

			} while ($res = oci_fetch ($curseur));
     
			echo ("
          </select>
					<br /><br />
           Attention si vous supprimez le dossier ca supprimera egalement tout les tickets qu'il contient 
           <br /><br />
					<input type=\"submit\" value=\"supprimer le dossier\" />
					<input type=\"reset\" value=\"Annuler\" />
				</form>
			");

		}

	}

	// on libère le curseur
	oci_free_statement($curseur);
  echo "</table>";
 	include('pied.php');

?>
