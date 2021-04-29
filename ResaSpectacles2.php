<?php
 $titre = "Récapitulatif par spéctacle";
 include('entete.php');
 
 
 
 $requete = ("
            Select B.nomS,B.noSpec,nvl(count(noplace),0) as nbplace,B.daterep
        		From (SELECT nomS,noSpec,noPlace,to_char(daterep,'Day, DD-Month-YYYY HH:MI') as daterep
        		from theatre.LesTickets natural join theatre.lesSpectacles natural join theatre.lesRepresentations) A Right join (Select nomS,noSpec,to_char(daterep,'Day, DD-Month-YYYY HH:MI') as daterep     From theatre.LesRepresentations natural join theatre.lesSpectacles) B on (A.daterep=B.daterep )
        		group by B.nomS,B.noSpec,B.daterep
            order by B.nomS
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
			echo "<p class=\"erreur\"><b> Spectacle inconnu </b></p>" ;

		}
		else {

			// on affiche la table qui va servir a la mise en page du resultat
      echo "<table><tr><th>nomS</th><th>noSpec</th><th>nbPlace</th><th>daterep</th></tr>" ;
			do {
         //echo "$nomS ";
        // cas ou il y a plusieurs spectacles et plusieurs representations apres
                $nomS = oci_result($curseur, 1) ;
        				$noSpec = oci_result($curseur, 2) ;
        				$nbPlace = oci_result($curseur, 3) ;
        				$daterep = oci_result($curseur, 4) ;
        				echo "<tr><td>$nomS</td><td>$noSpec</td><td>$nbPlace</td><td>$daterep</td></tr>";
       
			} while (oci_fetch ($curseur));
       
echo "</table>";

		
		}
    
	}

	// on libère le curseur
	oci_free_statement($curseur);
 
 
 include('pied.php');

?>
