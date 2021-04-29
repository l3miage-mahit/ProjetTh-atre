<?php

	$titre = 'Modification du dossier';
	include('entete.php');
  $noDossier = $_POST['categorie'];
  
  $date = date("d-m-Y H:i");//date actuel
  echo("Dossier numero:$noDossier");
   echo(" <br /><br />");
   
  echo "<table><tr><th>Ajouter Tickets (representation disponible a partir de maintenant)</th></tr>" ;
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
			echo "<p class=\"erreur\"><b>Aucune Représentions dans la base de donnée</b></p>" ;

		}
		else {
			// on affiche le formulaire de sélection
			echo ("
				<form action=\"reservationmodifficationdossierajout.php?noDossier=$noDossier\" method=\"post\">
					<label for=\"inp_categorie\">Sélectionnez la Representions ou vous souhaitez ajouter une place :</label>
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
  
  echo "<table><tr><th>Modifier ticket (changement de place)</th></tr>" ;
  $requete = ("
	 SELECT noSerie From LesTickets where nodossier=$noDossier
   Order by noSerie
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
			echo "<p class=\"erreur\"><b>Aucune ticket dans la base de donnée</b></p>" ;

		}
		else {
			// on affiche le formulaire de sélection
			echo ("
				<form action=\"changementplace.php?noDossier=$noDossier\" method=\"post\">
					<label for=\"inp_categorie\">Sélectionnez le ticket ou vous voulez changer de place :</label>
          <select id=\"inp_categorie\" name=\"categorie\">
			");

			// création des options
			do {

				$noSerie = oci_result($curseur, 1);
        
        	echo ("<option value=\"$noSerie\">$noSerie</option>");

			} while ($res = oci_fetch ($curseur));
     
			echo ("
          </select>
					<br /><br />
					<input type=\"submit\" value=\"Modifier\" />
					<input type=\"reset\" value=\"Annuler\" />
				</form>
			");

		}

	}

	// on libère le curseur
	oci_free_statement($curseur);
  echo "</table>";
  
  echo "<table><tr><th>Modifier ticket (changement de numero de dossier)</th></tr>" ;
  $requete = ("
	 SELECT noSerie From LesTickets where nodossier=$noDossier
   Order by noSerie
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
			echo "<p class=\"erreur\"><b>Aucune ticket dans la base de donnée</b></p>" ;

		}
		else {
			// on affiche le formulaire de sélection
			echo ("
				<form action=\"changementnodossier.php?noDossier=$noDossier\" method=\"post\">
					<label for=\"inp_categorie\">Sélectionnez le ticket dont vous voulez changer de dossier :</label>
          <select id=\"inp_categorie\" name=\"categorie\">
			");

			// création des options
			do {

				$noSerie = oci_result($curseur, 1);
        
        	echo ("<option value=\"$noSerie\">$noSerie</option>");

			} while ($res = oci_fetch ($curseur));
     
			echo ("
          </select>
					<br /><br />
			<label for=\"inp_categorie\">Veuillez entrer le numero du nouveau dossier :</label>
			<input type=\"text\" name=\"nodossier\" />
			<br /><br />
					<input type=\"submit\" value=\"Modifier\" />
					<input type=\"reset\" value=\"Annuler\" />
				</form>
			");

		}

	}

	// on libère le curseur
	oci_free_statement($curseur);
  echo "</table>";
  
  
  echo "<table><tr><th>Modifier ticket (Modification de la Représentation)</th></tr>" ;
    $requete = ("
	 SELECT noSerie From LesTickets where nodossier=$noDossier
   Order by noSerie
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
			echo "<p class=\"erreur\"><b>Aucune ticket dans la base de donnée</b></p>" ;

		}
		else {
			// on affiche le formulaire de sélection
			echo ("
				<form action=\"changementRepresentation.php?noDossier=$noDossier\" method=\"post\">
					<label for=\"inp_categorie\">Sélectionnez le ticket ou vous voulez changer de représentation :</label>
          <select id=\"inp_categorie\" name=\"categorie\">
			");

			// création des options
			do {

				$noSerie = oci_result($curseur, 1);
        
        	echo ("<option value=\"$noSerie\">$noSerie</option>");

			} while ($res = oci_fetch ($curseur));
     
		

		}

	}
  	echo ("</select>");
    echo ("<br /><br />");
	// on libère le curseur
	oci_free_statement($curseur);
 
 
  $requete2 = ("
	 SELECT to_char(daterep,'DD-MM-YYYY HH:MI') as dateRep, noSpec,nomS
		FROM lesRepresentations natural join lesspectacles
    where daterep>to_date('$date','DD-MM-YYYY HH24:MI')
    ORDER BY noSpec
   ");
  
   // analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete2) ;

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
			echo "<p class=\"erreur\"><b>Aucune Représentations dispo dans la base de donnée</b></p>" ;

		}
		else {
			// on affiche le formulaire de sélection
			echo ("
					<label for=\"inp_categorie\">Sélectionnez la nouvelle Représentations (ici seulement les représentations disponible) :</label>
          <select id=\"inp_categorie\" name=\"categorie2\">
			");

			// création des options
			do {

				$dateRep = oci_result($curseur, 1);
        $numS= oci_result($curseur, 2);
        $nomS= oci_result($curseur, 3);
       	echo ("<option value=\"$dateRep, $numS\">$dateRep --- $nomS --- $numS</option>");

			} while ($res = oci_fetch ($curseur));
     
		

		}

	}

	// on libère le curseur
	oci_free_statement($curseur);
 	echo ("</select>
					<br /><br />
			");
 echo ("
          
					<input type=\"submit\" value=\"Modifier\" />
					<input type=\"reset\" value=\"Annuler\" />
				</form>
			");
 
  
  
  
  echo "</table>";
  
  
  echo "<table><tr><th>Annuler ticket (supprimer ticket)</th></tr>" ;
  $requete = ("
	 SELECT noSerie From LesTickets where nodossier=$noDossier
   Order by noSerie
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
			echo "<p class=\"erreur\"><b>Aucun ticket dans la base de donnée</b></p>" ;

		}
		else {
			// on affiche le formulaire de sélection
			echo ("
				<form action=\"supprimerTicket.php?noDossier=$noDossier\" method=\"post\">
					<label for=\"inp_categorie\">Sélectionnez le ticket a annuler :</label>
          <select id=\"inp_categorie\" name=\"categorie\">
			");

			// création des options
			do {

				$noSerie = oci_result($curseur, 1);
        
        	echo ("<option value=\"$noSerie\">$noSerie</option>");

			} while ($res = oci_fetch ($curseur));
     
			echo ("
          </select>
					<br /><br />
					<input type=\"submit\" value=\"supprimer\" />
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