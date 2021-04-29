<?php

	$titre = 'ajout du ticket';
  include('entete.php');
  
  $chaine = $_POST['categorie'];
  $numS=intval(substr($chaine, 18));
  $dateRep=substr($chaine,0, 16);
  $nodossier=$_GET['noDossier'];
  
  echo "<table><tr><th>nodossier:$nodossier choix des places pour le numero de Spectacle:$numS a la date $dateRep</th></tr>" ;
    $requete = ("
	select noPlace,noRang From lesSieges 
  Minus
  Select noPlace,noRang From LesTickets where noSpec=$numS and to_char(dateRep,'DD-MM-YYYY HH:MI')='$dateRep'
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
			echo "<p class=\"erreur\"><b>Aucune place et rang dans la base de donnée</b></p>" ;

		}
		else {
			// on affiche le formulaire de sélection
			echo ("
				<form action=\"ajoutTicket.php?noDossier=$nodossier&amp;dateRep=$dateRep&amp;numS=$numS\" method=\"post\">
					<label for=\"inp_categorie\">Selectionner votre place et rang :</label>
          <select id=\"inp_categorie\" name=\"categorie\">
			");

			// création des options
			do {

				$noPlace = oci_result($curseur, 1);
        $noRang= oci_result($curseur, 2);
        	echo ("<option value=\"$noPlace, $noRang\">place:$noPlace--rang:$noRang</option>");

			} while ($res = oci_fetch ($curseur));
     
			echo ("
          </select>
					<br /><br />
					<input type=\"submit\" value=\"valider les places\" />
					<input type=\"reset\" value=\"Annuler\" />
				</form>
			");

		}

	}

	// on libère le curseur
	oci_free_statement($curseur);
  echo "</table>";
  
  
  //?numS=$numS&amp;dateRep=$dateRep\
 
  include('pied.php');

?>