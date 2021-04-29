<?php
  
  $titre = 'Modification de date de representation ';
	include('entete.php');
 
  $date=$_POST['date'];
  $heure=$_POST['heure'];
  $numS=intval($_GET['numS']);
  $dateRep=$_GET['dateRep'];
  
  
  
  $requete = "UPDATE lesRepresentations SET dateRep = to_date('$date $heure', 'DD-MM-YYYY HH24:MI')  WHERE to_char(dateRep,'DD-MM-YYYY HH:MI')='$dateRep' AND noSpec=$numS";
  // analyse de la requete 1 et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// execution de la requete
	$ok = oci_execute ($curseur, OCI_NO_AUTO_COMMIT) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {

		echo LeMessage ("majRejetee");
		// terminaison de la transaction : annulation
		oci_rollback ($lien) ;

	}
	else {
       echo LeMessage ("majOK") ;
			// terminaison de la transaction : validation
			oci_commit ($lien) ;
      echo '<font color="red">le spectacle numero </font>'; 
      echo "$numS ";
      echo '<font color="red">a la date </font>';
      echo "$dateRep ";
      echo '<font color="red">a changer de date de representation qui est maintenant: </font>';
      echo "$date $heure";
      
 }
 // on libère le curseur
	oci_free_statement($curseur);
  
  
  
  include('pied.php');
?>