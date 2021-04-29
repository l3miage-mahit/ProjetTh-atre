<?php

	$titre = 'Suppression du dossier';
	include('entete.php');
 
  $noDossier = $_POST['categorie'];
  
  //on Supprime les ticket avec le numero de dossier
  $requete = "delete from lesTickets where noDossier= $noDossier ";
  // analyse de la requete 1 et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// execution de la requete
	$ok = oci_execute ($curseur, OCI_NO_AUTO_COMMIT) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {
    echo ("MAJ suppresion tout les Ticket du dossier no:$noDossier");
		echo LeMessage ("majRejetee");
		// terminaison de la transaction : annulation
		oci_rollback ($lien) ;

	}
	else {
       echo ("MAJ suppresion tout les Ticket du dossier no:$noDossier");
       echo LeMessage ("majOK") ;
			// terminaison de la transaction : validation
			oci_commit ($lien) ;
 }
 // on libère le curseur
	oci_free_statement($curseur);
  
  
  //on Supprime le dossier 
  $requete = "delete from lesDossiers where noDossier= $noDossier ";
  // analyse de la requete 1 et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// execution de la requete
	$ok = oci_execute ($curseur, OCI_NO_AUTO_COMMIT) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {
   echo ("<br /><br />");
    echo ("MAJ suppresion du dossier no:$noDossier");
		echo LeMessage ("majRejetee");
		// terminaison de la transaction : annulation
		oci_rollback ($lien) ;

	}
	else {
       echo ("<br /><br />");
       echo ("MAJ suppresion du dossier no:$noDossier");
       echo LeMessage ("majOK") ;
			// terminaison de la transaction : validation
			oci_commit ($lien) ;
 }
 // on libère le curseur
	oci_free_statement($curseur);
 
  include('pied.php');

?>