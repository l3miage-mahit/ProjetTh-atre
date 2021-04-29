<?php

	$titre = 'Suppression du ticket';
	include('entete.php');
  $noTicket = $_POST['categorie'];
  $noDossier = $_GET['noDossier'];
  
  //---------on le numero de place et le Rang 
  $requete = ("select noPlace,noRang From lesTickets where noSerie=$noTicket ");
  $curseur = oci_parse ($lien, $requete) ;
  $ok = @oci_execute ($curseur) ;
	$res = oci_fetch ($curseur);
	$noPlace = oci_result($curseur, 1);
  $rang  = oci_result($curseur, 1);
  oci_free_statement($curseur);
  
  //---------on recupere le prix de la place 
  $requete = ("select prix From lesSieges natural join lesZones natural join lesCategories where noPlace=$noPlace and noRang=$rang");
  $curseur = oci_parse ($lien, $requete) ;
  $ok = @oci_execute ($curseur) ;
	$res = oci_fetch ($curseur);
	$Prix = oci_result($curseur, 1);
  oci_free_statement($curseur);
  
  //--------on met a jour le dossier en mettant a jour le prix avant on recupere le montant du dossier pour l'additionn� au prix de la place
  $requete = ("select montant From lesdossiers where noDossier=$noDossier");
  $curseur = oci_parse ($lien, $requete) ;
  $ok = @oci_execute ($curseur) ;
	$res = oci_fetch ($curseur);
	$montant = oci_result($curseur, 1);
  oci_free_statement($curseur);
  
  //------mise a jour montant
  $montant=$montant-$Prix;
  $requete = "UPDATE lesdossiers SET montant=$montant WHERE noDossier=$noDossier";
  // analyse de la requete 1 et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// execution de la requete
	$ok = oci_execute ($curseur, OCI_NO_AUTO_COMMIT) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {
    echo("Mise a jour montant dossier :");
		echo LeMessage ("majRejetee");
		// terminaison de la transaction : annulation
		oci_rollback ($lien) ;

	}
	else {
       echo("Mise a jour montant dossier :");
       echo LeMessage ("majOK") ;
			// terminaison de la transaction : validation
			oci_commit ($lien) ;
      echo("<br /><br />");
      echo '<font color="red">le numero de dossier </font>'; 
      echo "$noDossier ";
      echo '<font color="red">nouveau montant: </font>';
      echo "$montant ";
       echo("<br /><br />");
      
 }
 // on libère le curseur
	oci_free_statement($curseur);
  
  //on Supprime le ticket
  $requete = "delete from lesTickets where noSerie=$noTicket ";
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
       echo ("MAJ suppresion Ticket");
       echo LeMessage ("majOK") ;
			// terminaison de la transaction : validation
			oci_commit ($lien) ;
 }
 // on libère le curseur
	oci_free_statement($curseur);
  
  include('pied.php');

?>