<?php

	$titre = 'Recapitulatif Modification du ticket';
	include('entete.php');
  $nodossier =$_GET['noDossier'];
  $numS=$_GET['numS'];
  $dateRep=$_GET['dateRep'];
  $noTicket=$_GET['noTicket'];
  
  $chaine=$_POST['categorie'];  
  $noPlace=intval(substr($chaine,0,2));
  $rang=intval(substr($chaine, 3));
  //noTicket
  
  //---------on recupere le prix de la place la nouvelle place 
  $requete = ("select prix From lesSieges natural join lesZones natural join lesCategories where noPlace=$noPlace and noRang=$rang");
  $curseur = oci_parse ($lien, $requete) ;
  $ok = @oci_execute ($curseur) ;
	$res = oci_fetch ($curseur);
	$Prix = oci_result($curseur, 1);
  oci_free_statement($curseur);
  
  //---------on recupere le rang et l'ancienne place
  $requete = ("select noPlace,noRang From lesTickets where noSerie=$noTicket");
  $curseur = oci_parse ($lien, $requete) ;
  $ok = @oci_execute ($curseur) ;
	$res = oci_fetch ($curseur);
	$Aplace = oci_result($curseur, 1);
  $Arang = oci_result($curseur, 2);
  oci_free_statement($curseur);
  
  //---------on recupere le prix de l'ancienne place
  $requete = ("select prix From lesSieges natural join lesZones natural join lesCategories where noPlace=$Aplace and noRang=$Arang");
  $curseur = oci_parse ($lien, $requete) ;
  $ok = @oci_execute ($curseur) ;
	$res = oci_fetch ($curseur);
	$APrix = oci_result($curseur, 1);
  oci_free_statement($curseur);
  
  //---------on recupere le montant du dossier pour le mettre a jour
  $requete = ("select montant From lesdossiers where noDossier=$nodossier");
  $curseur = oci_parse ($lien, $requete) ;
  $ok = @oci_execute ($curseur) ;
	$res = oci_fetch ($curseur);
	$montant = oci_result($curseur, 1);
  oci_free_statement($curseur);
  
  $montant=$montant-$APrix+$Prix;
  
  //-------modification du ticket
  
  $requete = "UPDATE lesTickets SET noPlace=$noPlace WHERE noSerie=$noTicket";
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

  
  $requete = "UPDATE lesTickets SET noRang=$rang WHERE noSerie=$noTicket";
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
  
  //mise a jour prix dans le dossier
    //mise � jour du prix dans le dossier
  
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