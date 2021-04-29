<?php

	$titre = 'Modification du numero de la Representation';
	include('entete.php');

  $nodossier=$_GET['noDossier'];
  $noticket=$_POST['categorie'];
  $chaine = $_POST['categorie2'];
  $numS=intval(substr($chaine, 18));
  $dateRep=substr($chaine,0, 16);
 
  //---------affichage ancienne place et message si les places disponible
  $requete1 = ("select noPlace,noRang from lestickets where noSerie=$noticket");
  $curseur = oci_parse ($lien, $requete1) ;
  $ok1 = @oci_execute ($curseur) ;
	$res1 = oci_fetch ($curseur);
	$AncienPlace = oci_result($curseur, 1);
  $AncienRang = oci_result($curseur, 2);
  oci_free_statement($curseur);
  
  echo("Ancienne Place:$AncienPlace et Ancien Rang:$AncienRang ");
  
    
  $requete = ("
		SELECT noPlace,noRang From (select noPlace,noRang From lesSieges Minus Select noPlace,noRang From LesTickets where noSpec=$numS and to_char(dateRep,'DD-MM-YYYY HH:MI')='$dateRep') where noPlace=$AncienPlace and noRang=$AncienRang ");
  
   // analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// execution de la requete
	$ok = @oci_execute ($curseur) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {

		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur);
		
	}
	else {

		// oci_execute a réussi, on fetch sur le premier résultat
		$res = oci_fetch ($curseur);

		if (!$res) {

			// il n'y a aucun résultat
        echo("Désolé ancienne place indisponible veuillez choisir de nouvelle place :");

		}
		else {
			// on affiche le formulaire de sélection  
      echo("Vous pouvez Re-sélectionner vos anciennne place elle sont disponible");
		}

	}

	// on libère le curseur
	oci_free_statement($curseur);
 
  //---------------------------------------------------------------------
  
  
  echo "<table><tr><th>Choisir dans les Place Disponible pour la nouvelle Representation numero:$numS , date:$dateRep</th></tr>" ;
       $requete = ("
      	select noPlace,noRang From lesSieges 
        Minus
        Select noPlace,noRang From LesTickets where noSpec=1
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
      				<form action=\"changementRepresentation2.php?noDossier=$nodossier&amp;noTicket=$noticket&amp;dateRep=$dateRep&amp;noSpec=$numS\" method=\"post\">
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
  
  //?noDossier=$nodossier&amp;numS=$numS&amp;noTicket=$noticket
  include('pied.php');



?>