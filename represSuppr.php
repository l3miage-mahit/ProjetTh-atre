<?php
	$titre = 'supression';
	include('entete.php');
 
 
 
  $chaine = $_POST['categorie'];
  $numS=substr($chaine, 18);
  $dateRep=substr($chaine,0, 16);
  
  
  //select * from lesrepresentations where to_char(dateRep,'DD-MM-YYYY HH:MI')>='15-01-2020 00:10';
  $requete = "delete from lesrepresentations where to_char(dateRep,'DD-MM-YYYY HH:MI')='$dateRep' AND noSpec=$numS ";
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
 }
 // on libère le curseur
	oci_free_statement($curseur);
include('pied.php');
?>