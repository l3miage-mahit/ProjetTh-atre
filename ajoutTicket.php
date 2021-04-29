<?php
  $test=0;
	$titre = 'Ajout du ticket';
	include('entete.php');
  $nodossier =$_GET['noDossier'];
  $numS=$_GET['numS'];
  $dateRep=$_GET['dateRep'];
  $chaine=$_POST['categorie'];
  
  $noPlace=intval(substr($chaine,0,2));
  $rang=intval(substr($chaine, 3));
  
  
  $date = date("d-m-Y");//date actuel
  $heure = date("H:i:s");//heure actuel
    
  //ajout du ticket
  //on recupere le numero de serie maximum
  $requete = ("select max(noSerie) from lestickets");
  $curseur = oci_parse ($lien, $requete) ;
  $ok = @oci_execute ($curseur) ;
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
			
        $numTicket = 0;
		}
		else {
			// on affiche le formulaire de sélection
			$numTicket = oci_result($curseur, 1);

		}
  }
  
  oci_free_statement($curseur);
  $numTicket=$numTicket+1;
  //echo("$numTicket");
  //to_date('$date $heure', 'DD-MM-YYYY HH24:MI')
 // construction des requêtes
 $requete = "INSERT INTO LesTickets(noSerie,noSpec,dateRep,noplace,norang,dateEmiss,noDossier) values ($numTicket,$numS,to_date('$dateRep', 'DD-MM-YYYY HH24:MI'),$noPlace,$rang,to_date('$date $heure', 'DD-MM-YYYY HH24:MI:SS '),$nodossier)";
 
 
 
 // analyse de la requete et association au curseur
 $curseur = oci_parse ($lien, $requete) ;
 // execution de la requete
		$ok = @oci_execute ($curseur, OCI_NO_AUTO_COMMIT) ;

		// on teste $ok pour voir si oci_execute s'est bien passé
		if (!$ok) {

			echo LeMessage ("majRejetee")."<br /><br />";
			$e = oci_error($curseur);
			if ($e['code'] == 1) {
				echo LeMessage ("représentationconnue") ;
			}
			else {
				echo LeMessageOracle ($e['code'], $e['message']) ;
			}

			// terminaison de la transaction : annulation
			oci_rollback ($lien) ;

		}
		else {
      echo("<br /><br />
      Mise a jour Ticket:
      ");
			echo LeMessage ("majOK") ;
			// terminaison de la transaction : validation
      oci_commit ($lien) ;
      echo("<br /><br />
      Ajout tickets numero $numTicket pour le sperctable $numS, a la date:$dateRep, noPlace:$noPlace, Rang: $rang, DateEmission:$date $heure Ajout au dossier:  $nodossier .<br /><br />
      ");
			oci_commit ($lien) ;
      $test=1;

		}

	// on libère le curseur
	oci_free_statement($curseur);
 
 if ($test==1){
 //select prix From lesSieges natural join lesZones natural join lesCategories where noPlace=1 and noRang=2 ;
  //---------on recupere le prix de la place 
  $requete = ("select prix From lesSieges natural join lesZones natural join lesCategories where noPlace=$noPlace and noRang=$rang");
  $curseur = oci_parse ($lien, $requete) ;
  $ok = @oci_execute ($curseur) ;
	$res = oci_fetch ($curseur);
	$Prix = oci_result($curseur, 1);
  oci_free_statement($curseur);
  
  //--------on met a jour le dossier en mettant a jour le prix avant on recupere le montant du dossier pour l'additionn� au prix de la place
  $requete = ("select montant From lesdossiers where noDossier=$nodossier");
  $curseur = oci_parse ($lien, $requete) ;
  $ok = @oci_execute ($curseur) ;
	$res = oci_fetch ($curseur);
	$montant = oci_result($curseur, 1);
  oci_free_statement($curseur);
  
  //------mise a jour montant
  $montant=$montant+$Prix;
  $requete = "UPDATE lesdossiers SET montant=$montant WHERE noDossier=$nodossier";
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
      echo "$nodossier ";
      echo '<font color="red">nouveau montant: </font>';
      echo "$montant ";
      
 }
 // on libère le curseur
	oci_free_statement($curseur);
  }
  
  
  include('pied.php');

?>


