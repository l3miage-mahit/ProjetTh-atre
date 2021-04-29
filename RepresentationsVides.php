<?php

 $titre = "Représentation sans Place réservées";
 include('entete.php');
 
 $requete = ("
 SELECT nomS,noSpec,DateRep
 from theatre.LesSpectacles natural join theatre.lesRepresentations
 minus 
 Select nomS,noSpec,DateRep
 From theatre.lesTickets natural join theatre.lesSpectacles natural join theatre.lesRepresentations group by nomS,noSpec,DateRep

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
			echo "<p class=\"erreur\"><b> tous les spectacles ont au moins une place de vendu </b></p>" ;

		}
		else {

			// on affiche la table qui va servir a la mise en page du resultat
			echo "<table><tr><th>liste spectacle</th><th>noSpec</th><th>DateRep</th></tr>" ;

			// on affiche un résultat et on passe au suivant s'il existe
			do {

				
        $nomS = oci_result($curseur,1) ;
        $noSpec = oci_result($curseur,2) ;
        $dateRep = oci_result($curseur,3) ;
				echo "<tr><td>".$nomS."</td><td>".$noSpec."</td><td>".$dateRep."</td></tr>";

			} while (oci_fetch ($curseur));

			echo "</table>";
		}

	}

	// on libère le curseur
	oci_free_statement($curseur);
 
 include('pied.php');

?>