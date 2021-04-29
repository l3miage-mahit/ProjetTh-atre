<?php
  //UPDATE table SET nom_colonne_1 = 'nouvelle valeur' WHERE condition
  $titre = 'Modification';
	include('entete.php');
  //session_start();
  // Lecture d'une valeur du tableau de session
  //echo $_SESSION['noSpec'];
  //avant
   //
  
  $chaine = $_POST['categorie'];
  $numS=substr($chaine, 18);
  $dateRep=substr($chaine,0, 16);
 
  echo "<table><tr><th>Modifier la representation numero $numS a la date $dateRep</th></tr>" ;
  echo "<table><tr><th>modifier la date de representation (changement de date):</th></tr>" ;
   echo ("
		<form action=\"represModifDate.php?numS=$numS&amp;dateRep=$dateRep\" method=\"POST\">
      <label for=\"inp_categorie\">Veuillez saisir la nouvelle date (FORMAT DD-MM-YYYY):</label>
			<input type=\"text\" name=\"date\" />
			<br /><br />
       <label for=\"inp_categorie\">Veuillez saisir la nouvelle heure (FORMAT HH:MI) :</label>
			<input type=\"text\" name=\"heure\" />
			<br /><br />
      
			<input type=\"submit\" value=\"Modifier DateRep\" />
			<input type=\"reset\" value=\"Annuler\" />
		</form>
	"); 
  echo "</table>";
  
  echo "<table><tr><th>modifier le numero de representation (changement d'affiche):</th></tr>" ;
    $requete = ("
		SELECT noSpec,nomS 
		FROM lesSpectacles
    where noSpec not in $numS
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
			echo "<p class=\"erreur\"><b>Aucune categorie dans la base de donnée</b></p>" ;

		}
		else {
			// on affiche le formulaire de sélection
			echo ("
				<form action=\"represModif_2.php?numS=$numS&amp;dateRep=$dateRep\" method=\"post\">
					<label for=\"inp_categorie\">Sélectionnez une Representions :</label>
          <select id=\"inp_categorie\" name=\"newNumS\">
			");

			// création des options
			do {

        $numS= oci_result($curseur, 1);
        $nomS= oci_result($curseur, 2);
        	echo ("<option value=\"$numS\">$numS --- $nomS</option>");

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
  
  echo "</table>";
  
  include('pied.php');
?>