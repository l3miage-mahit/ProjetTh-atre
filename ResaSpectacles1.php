<?php

 $titre = "Récapitulatif par spéctacle";
 include('entete.php');
 
 $requete = ("
 Select nomS,noSpec
 from theatre.lesSpectacles
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

			// on affiche un résultat et on passe au suivant s'il existe
			do {

				$nomS = oci_result($curseur,1) ;
        $numS = oci_result($curseur,2) ;
        echo "<table><tr><th>$nomS</th></tr>" ;
        
        	// construction de la requete pour le second curseur
        	$requete2 = ("
        		Select B.noSpec,nvl(count(noplace),0) as nbplace,to_char(B.daterep,'Day, DD-Month-YYYY HH:MI') as daterep
            From theatre.lesTickets A right join theatre.lesRepresentations B on (A.daterep=B.daterep and A.noSpec=B.noSpec)
        		where lower(B.noSpec)=lower(:n)
        		group by B.noSpec,B.daterep
            order by nbplace
        
        	");
        
        	// analyse de la requete et association au curseur
        	$curseur2 = oci_parse ($lien, $requete2) ;
        
        	// affectation de la variable
        	oci_bind_by_name ($curseur2, ':n',$numS);
        
        	// execution de la requete
        	$ok2 = @oci_execute ($curseur2) ;
        
        	// on teste $ok pour voir si oci_execute s'est bien passé
        	if (!$ok2) {
        
        		// oci_execute a échoué, on affiche l'erreur
        		$error_message2 = oci_error($curseur2);
        		echo "<p class=\"erreur\">{$error_message['message']}</p>";
        
        	}
        	else {
        
        		// oci_execute a réussi, on fetch sur le premier résultat
        		$res2 = oci_fetch ($curseur2);
        
        		if (!$res2) {
        
        			// il n'y a aucun résultat
        			echo "<p class=\"erreur\"><b>il existe pas de representation pour ce spectacle</b></p>" ;
        
        		}
        		else {
        
        			// on affiche la table qui va servir a la mise en page du resultat
        			echo "<table><tr><th>nomS</th><th>noSpec</th><th>nbPlace</th><th>daterep</th></tr>" ;
        
        			// on affiche un résultat et on passe au suivant s'il existe
        			do {
        
        				$nomSB = oci_result($curseur, 1) ;
        				$noSpec = oci_result($curseur2, 1) ;
        				$nbPlace = oci_result($curseur2, 2) ;
        				$daterep = oci_result($curseur2, 3) ;
        				echo "<tr><td>$nomSB</td><td>$noSpec</td><td>$nbPlace</td><td>$daterep</td></tr>";
        
        			} while (oci_fetch ($curseur2));
        
        			echo "</table>";
        		}
        
        	}
        
        	// on libère le curseur
        	oci_free_statement($curseur2);
        
        
        
        
       	echo "</table>";

			} while (oci_fetch ($curseur));

		
		}

	}

	// on libère le curseur
	oci_free_statement($curseur);
 
 
 include('pied.php');

?>