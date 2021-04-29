<?php

	
	$titre = 'Modification du numero de la Representation';
	include('entete.php');
 
  $nodossier=$_GET['noDossier'];
  $noticket=$_GET['noTicket'];
  $numS=intval($_GET['noSpec']);
  //noPlace noRang
  $chaine=$_POST['categorie'];
  $noPlace=intval(substr($chaine,0,2));
  $rang=intval(substr($chaine, 3));
  $dateRep=$_GET['dateRep'];
  
  $date=substr($dateRep,0,10);
  $heure=substr($dateRep,11);
  

  //ancienne place
  $requete1 = ("select noPlace,noRang from lestickets where noSerie=$noticket");
  $curseur = oci_parse ($lien, $requete1) ;
  $ok1 = @oci_execute ($curseur) ;
	$res1 = oci_fetch ($curseur);
	$AncienPlace = oci_result($curseur, 1);
  $AncienRang = oci_result($curseur, 2);
  oci_free_statement($curseur);
  
  //Prix ancienne place 
  $requete = ("select prix From lesSieges natural join lesZones natural join lesCategories where noPlace=$AncienPlace and noRang=$AncienRang");
  $curseur = oci_parse ($lien, $requete) ;
  $ok = @oci_execute ($curseur) ;
	$res = oci_fetch ($curseur);
	$AncienPrix = oci_result($curseur, 1);
  oci_free_statement($curseur);
  
  
  //Prix nouvelle place
  $requete = ("select prix From lesSieges natural join lesZones natural join lesCategories where noPlace=$noPlace and noRang=$rang");
  $curseur = oci_parse ($lien, $requete) ;
  $ok = @oci_execute ($curseur) ;
	$res = oci_fetch ($curseur);
	$Prix = oci_result($curseur, 1);
  oci_free_statement($curseur);
  
  
  //Montant
  $requete = ("select montant From lesdossiers where noDossier=$nodossier");
  $curseur = oci_parse ($lien, $requete) ;
  $ok = @oci_execute ($curseur) ;
	$res = oci_fetch ($curseur);
	$montant = oci_result($curseur, 1);
  oci_free_statement($curseur);
  
  //calcule nouveau montant
  $montant=$montant-$AncienPrix+$Prix;
  
  
  
  //-------mise a jour tichet modif representation 
  
  $requete = "UPDATE lesTickets SET noPlace=$noPlace WHERE noSerie=$noticket";
  // analyse de la requete 1 et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// execution de la requete
	$ok = oci_execute ($curseur, OCI_NO_AUTO_COMMIT) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {
    echo("MAJ Place");
		echo LeMessage ("majRejetee");
		// terminaison de la transaction : annulation
		oci_rollback ($lien) ;

	}
	else {
       echo("MAJ Place");
       echo LeMessage ("majOK") ;
			// terminaison de la transaction : validation
			oci_commit ($lien) ;
      
 }
 // on libère le curseur
	oci_free_statement($curseur);

  
  $requete = "UPDATE lesTickets SET noRang=$rang WHERE noSerie=$noticket";
  // analyse de la requete 1 et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// execution de la requete
	$ok = oci_execute ($curseur, OCI_NO_AUTO_COMMIT) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {
   echo(" <br /><br />");
    echo("MAJ Rang:");
		echo LeMessage ("majRejetee");
		// terminaison de la transaction : annulation
		oci_rollback ($lien) ;

	}
	else {
       echo(" <br /><br />");
       echo("MAJ Rang:");
       echo LeMessage ("majOK") ;
			// terminaison de la transaction : validation
			oci_commit ($lien) ;
      
 }
 // on libère le curseur
	oci_free_statement($curseur);
 $requete = "UPDATE lesTickets SET noSpec=$numS,dateRep=to_date('$date $heure', 'DD-MM-YYYY HH24:MI') WHERE noSerie=$noticket";
  // analyse de la requete 1 et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// execution de la requete
	$ok = oci_execute ($curseur, OCI_NO_AUTO_COMMIT) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {
   echo(" <br /><br />");
    echo("MAJ Représentation");
		echo LeMessage ("majRejetee");
   $e = oci_error ($curseur);
		echo LeMessageOracle ($e['code'], $e['message']) ;
		// terminaison de la transaction : annulation
		oci_rollback ($lien) ;

	}
	else {
       echo(" <br /><br />");
       echo("MAJ Représentation");
       echo LeMessage ("majOK") ;
			// terminaison de la transaction : validation
			oci_commit ($lien) ;
      
 }
 // on libère le curseur
	oci_free_statement($curseur);
 
  //mise a jour montant
  $requete = "UPDATE lesDossiers SET montant=$montant WHERE nodossier=$nodossier";
  // analyse de la requete 1 et association au curseur
	$curseur = oci_parse ($lien, $requete) ;

	// execution de la requete
	$ok = oci_execute ($curseur, OCI_NO_AUTO_COMMIT) ;

	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {
   echo(" <br /><br />");
    echo("MAJ Nouveau Montant Dossier:");
		echo LeMessage ("majRejetee");
		// terminaison de la transaction : annulation
		oci_rollback ($lien) ;

	}
	else {
       echo(" <br /><br />");
       echo("MAJ Nouveau Montant Dossier:");
       echo LeMessage ("majOK") ;
			// terminaison de la transaction : validation
			oci_commit ($lien) ;
      
 }
 // on libère le curseur
	oci_free_statement($curseur);
  
 
 
  include('pied.php');

?>