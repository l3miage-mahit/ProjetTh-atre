<?php

	$titre = 'ajout du ticket (dans le nouveau dossier client)';
  include('entete.php');
  $nodossier=$_GET['noDossier'];
 
 
  $date = date("d-m-Y H:i");//date actuel

echo "<table><tr><th>Ajouter Tickets</th></tr>" ;
    $requete = ("
		SELECT to_char(daterep,'DD-MM-YYYY HH:MI') as dateRep, noSpec,nomS
		FROM lesRepresentations natural join lesspectacles
    where daterep>to_date('$date','DD-MM-YYYY HH24:MI')
    ORDER BY noSpec
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
			echo "<p class=\"erreur\"><b>Aucune représentation aprés $date</b></p>" ;

		}
		else {
			// on affiche le formulaire de sélection
			echo ("
				<form action=\"reservationmodifficationdossierajout.php?noDossier=$nodossier\" method=\"post\">
					<label for=\"inp_categorie\">Sélectionnez la Représentations ou vous souhaitez ajouter une place :</label>
          <select id=\"inp_categorie\" name=\"categorie\">
			");

			// création des options
			do {

				$dateRep = oci_result($curseur, 1);
        $numS= oci_result($curseur, 2);
        $nomS= oci_result($curseur, 3);
        	echo ("<option value=\"$dateRep, $numS\">$dateRep --- $nomS --- $numS</option>");

			} while ($res = oci_fetch ($curseur));
     
			echo ("
          </select>
					<br /><br />
					<input type=\"submit\" value=\"Ajouter\" />
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