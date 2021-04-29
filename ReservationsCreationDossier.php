<?php

	$titre = 'Creation nouveau dossier client';
	include('entete.php');
 
 $requete="select max(nodossier) from lesdossiers";
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
 
        //cas ou il existe pas encore de dossier
       $noDossier = 0 ;
       $noDossier=$noDossier+1;
       $requete1 = "INSERT INTO lesdossiers (noDossier, Montant) values ($noDossier,0)";
       $curseur1 = oci_parse ($lien, $requete1) ;
       $ok1 = @oci_execute ($curseur1, OCI_NO_AUTO_COMMIT) ;
       if (!$ok1) {
      			echo LeMessage ("majRejetee")."<br /><br />";  
      			// terminaison de la transaction : annulation
      			oci_rollback ($lien) ;
       }
       else {

			      echo LeMessage ("majOK") ;
            echo"------Nouveau dossier creer noDossier: $noDossier -----";
            //bouton pousoir pour ajout� des tick� dans le dossiers
			      // terminaison de la transaction : validation
			      oci_commit ($lien) ;
      }
	    // on libère le curseur
	    oci_free_statement($curseur1);  
			
		}
		else {
       $noDossier = oci_result($curseur,1) ;
       $noDossier=$noDossier+1;
       $requete1 = "INSERT INTO lesdossiers (noDossier, Montant) values ($noDossier,0)";
       $curseur1 = oci_parse ($lien, $requete1) ;
       // execution de la requete
       $ok1 = @oci_execute ($curseur1, OCI_NO_AUTO_COMMIT) ;
       if (!$ok1) {
      			echo LeMessage ("majRejetee")."<br /><br />";  
      			// terminaison de la transaction : annulation
      			oci_rollback ($lien) ;
       }
       else {

			      echo LeMessage ("majOK") ;
            echo"------Nouveau dossier creer noDossier: $noDossier -----";
            //bouton pousoir pour ajout� des tick� dans le dossiers
			      // terminaison de la transaction : validation
			      oci_commit ($lien) ;
      }
	    // on libère le curseur
	    oci_free_statement($curseur1);          
    }
}
  // on libère le curseur
	oci_free_statement($curseur);
 
  echo ("<br /><br /> "); 
  echo "<table><tr><th>Cliquez ci-dessous si vous souhaitez ajouter un tickets au nouveau dossier client ($noDossier): </th></tr>" ;
 echo ("
		    <form action=\"reservationmodifficationdossierajoutbis.php?noDossier=$noDossier\" method=\"POST\">
			      <input type=\"submit\" name=\"noDossier\" value=\"ajouter ticket dans le nouveau dossier client\" />
		</form>
	"); 
 
  echo "</table>";

	include('pied.php');

?>