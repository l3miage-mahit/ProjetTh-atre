<?php

	$titre = 'Modification du numero de dossier du ticket';
	include('entete.php');
  $noticket = intval($_POST['categorie']);
  $nodossier=$_GET['noDossier'];
  $nodossier2=$_POST['nodossier'];
  
  echo("Ancien numero de dossier:$nodossier, nouveau:$nodossier2, noticket: $noticket ");
  echo("<br /><br />");
  
  $requete = ("
	 SELECT nodossier From Lesdossiers where nodossier=$nodossier2
   ");
   $curseur = oci_parse ($lien, $requete) ;
   $ok = @oci_execute ($curseur) ;
   $res = oci_fetch ($curseur);
   
 if (!$ok) {

		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";

	}
 else{
   if (!$res) {
			// il n'y a aucun résultat
			echo "erreur lors de la saisie (Ce numero de dossier existe pas) " ;

		}
		else {
			//-------on modifie le numero de dossier du ticket 
        $requete1 = "UPDATE lesTickets SET noDossier=$nodossier2 WHERE noSerie=$noticket";
        // analyse de la requete 1 et association au curseur
      	$curseur1 = oci_parse ($lien, $requete1) ;
      
      	// execution de la requete
      	$ok1 = oci_execute ($curseur1, OCI_NO_AUTO_COMMIT) ;
      
      	// on teste $ok pour voir si oci_execute s'est bien passé
      	if (!$ok1) {
          echo("MAJ Numéro dossier");
      		echo LeMessage ("majRejetée");
      		// terminaison de la transaction : annulation
      		oci_rollback ($lien) ;
      
      	}
      	else {
             echo("MAJ Numéro dossier");
             echo LeMessage ("majOK") ;
      			// terminaison de la transaction : validation
      			oci_commit ($lien) ;
            
       }
       // on libère le curseur
      	oci_free_statement($curseur1);
      //-----------------
      //-----Recuperation Montant ancien dossier
      $requete5 = ("select montant From lesdossiers where noDossier=$nodossier");
      $curseur5 = oci_parse ($lien, $requete5) ;
      $ok5 = @oci_execute ($curseur5) ;
	    $res5 = oci_fetch ($curseur5);
      $montantAnci = oci_result($curseur5, 1);
      oci_free_statement($curseur5);
      
      //-----Recuperation Prix de la place
      $requete3 = ("select noPlace, noRang From lesTickets where noSerie=$noticket");
      $curseur3 = oci_parse ($lien, $requete3) ;
      $ok3 = @oci_execute ($curseur3) ;
	    $res3 = oci_fetch ($curseur3);
	    $noPlace = oci_result($curseur3, 1);
      $rang= oci_result($curseur3, 2);
      oci_free_statement($curseur3);
      
      
      $requete2 = ("select prix From lesSieges natural join lesZones natural join lesCategories where noPlace=$noPlace and noRang=$rang");
      $curseur2 = oci_parse ($lien, $requete2) ;
      $ok2 = @oci_execute ($curseur2) ;
	    $res2 = oci_fetch ($curseur2);
	    $Prix = oci_result($curseur2, 1);
      oci_free_statement($curseur2);
      
      //-----Recuperation Montant du nouveau dossier
      $requete4 = ("select montant From lesdossiers where noDossier=$nodossier2");
      $curseur4 = oci_parse ($lien, $requete4) ;
      $ok4 = @oci_execute ($curseur4) ;
	    $res4 = oci_fetch ($curseur4);
      $montantNVL = oci_result($curseur4, 1);
      oci_free_statement($curseur4);
      
      //----calcule chaque montant
      $montantNVL=$montantNVL+$Prix;
      $montantAnci=$montantAnci-$Prix;
      //-----Mise a jour Montant ancien dossier
      $requete6 = "UPDATE lesDossiers SET montant=$montantAnci WHERE nodossier=$nodossier";
        // analyse de la requete 1 et association au curseur
      	$curseur1 = oci_parse ($lien, $requete6) ;
      
      	// execution de la requete
      	$ok1 = oci_execute ($curseur1, OCI_NO_AUTO_COMMIT) ;
      
      	// on teste $ok pour voir si oci_execute s'est bien passé
      	if (!$ok1) {
         echo(" <br /><br />");
          echo("MAJ Montant Dossier de l'ancien dossier:");
      		echo LeMessage ("majRejetee");
      		// terminaison de la transaction : annulation
      		oci_rollback ($lien) ;
      
      	}
      	else {
             echo(" <br /><br />");
             echo("MAJ Montant Dossier de l'ancien dossier:");
             echo LeMessage ("majOK") ;
      			// terminaison de la transaction : validation
      			oci_commit ($lien) ;
            
       }
       // on libère le curseur
      	oci_free_statement($curseur1);
      
      
      //-----Mise a jour Montant nouveau dossier
      
      $requete7 = "UPDATE lesDossiers SET montant=$montantNVL WHERE nodossier=$nodossier2";
        // analyse de la requete 1 et association au curseur
      	$curseur1 = oci_parse ($lien, $requete7) ;
      
      	// execution de la requete
      	$ok1 = oci_execute ($curseur1, OCI_NO_AUTO_COMMIT) ;
      
      	// on teste $ok pour voir si oci_execute s'est bien passé
      	if (!$ok1) {
         echo(" <br /><br />");
          echo("MAJ Montant Dossier du nouveau dossier:");
      		echo LeMessage ("majRejetee");
      		// terminaison de la transaction : annulation
      		oci_rollback ($lien) ;
      
      	}
      	else {
             echo(" <br /><br />");
             echo("MAJ Montant Dossier du nouveau dossier:");
             echo LeMessage ("majOK") ;
      			// terminaison de la transaction : validation
      			oci_commit ($lien) ;
            
       }
       // on libère le curseur
      	oci_free_statement($curseur1);
      
      
   }
  }
   oci_free_statement($curseur);
   
 include('pied.php');

?>