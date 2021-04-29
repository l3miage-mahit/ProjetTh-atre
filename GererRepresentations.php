<?php

	$titre = 'Gerer les Representations';
	include('entete.php');
 
 

   echo "<table><tr><th>ajouter :</th></tr>" ;
   $requete = ("
		SELECT noSpec,nomS
		FROM lesspectacles
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
				<form action=\"represAjout.php\" method=\"POST\">
					<label for=\"inp_categorie\">Sélectionnez une Représentions :</label>
          <select id=\"inp_categorie\" name=\"categorie\">
			");

			// création des options
			do {

				
        $numS= oci_result($curseur, 1);
        $nomS= oci_result($curseur, 2);
        	echo ("<option value=\"$numS\">$nomS --- $numS</option>");
			} while ($res = oci_fetch ($curseur));

			echo ("
          </select>
			<br /><br />
					
			");

		}

	}

	// on libère le curseur
	oci_free_statement($curseur);
   
   echo ("
      <label for=\"inp_categorie\">Veuillez saisir une date DD-MM-YYYY:</label>
			<input type=\"text\" name=\"date\" />
			<br /><br />
       <label for=\"inp_categorie\">Veuillez saisir une heure HH:MI:</label>
			<input type=\"text\" name=\"heure\" />
			<br /><br />
      
			<input type=\"submit\" value=\"Ajouter une represensation\" />
			<input type=\"reset\" value=\"Annuler\" />
		</form>
	"); 
  echo "</table>";
  
  
  
  //delete from lesrepresentations where noSpec=120 and dateRep= ;

  echo "<table><tr><th>supprimer :</th></tr>" ;
   $requete = ("
		SELECT to_char(daterep,'DD-MM-YYYY HH:MI') as dateRep, noSpec,nomS
		FROM lesRepresentations natural join lesspectacles
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
				<form action=\"represSuppr.php\" method=\"post\">
					<label for=\"inp_categorie\">Sélectionnez une Représentions :</label>
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
					<input type=\"submit\" value=\"supprimer\" />
					<input type=\"reset\" value=\"Annuler\" />
				</form>
			");

		}

	}

	// on libère le curseur
	oci_free_statement($curseur);
  
  
  
  
  
  
  echo "</table>";
  
  echo "<table><tr><th>Modifier :</th></tr>" ;
  $requete = ("
		SELECT to_char(daterep,'DD-MM-YYYY HH:MI') as dateRep, noSpec,nomS
		FROM lesRepresentations natural join lesspectacles
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
				<form action=\"represModif.php\" method=\"post\">
					<label for=\"inp_categorie\">Sélectionnez une Representions :</label>
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
					<input type=\"submit\" value=\"modifier\" />
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
