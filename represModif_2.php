<?php
  //UPDATE table SET nom_colonne_1 = 'nouvelle valeur' WHERE condition
  
  $titre = 'Modification de numero de spectacle ';
	include('entete.php');
  $newNumS=intval($_POST['newNumS']);
  $numS=intval($_GET['numS']);
  $dateRep=$_GET['dateRep'];
  
  //UPDATE lesRepresentations SET dateRep = to_date('$date $heure', 'DD-MM-YYYY HH24:MI')  WHERE noSpec=$noSpec AND to_char(dateRep,'DD-MM-YYYY HH:MI')=$dateRep 
  
  
  $requete = "UPDATE lesRepresentations SET noSpec=$newNumS WHERE to_char(dateRep,'DD-MM-YYYY HH:MI')='$dateRep' AND noSpec=$numS";
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
      echo '<font color="red">a changer de numero de spectacle et devient le noSpec: </font>';
      echo "$newNumS";
      
 }
 // on libère le curseur
	oci_free_statement($curseur);
  
  
  /*
  
  echo '<font color="red">le spectacle numero </font>'; 
      echo "$numS ";
      echo '<font color="red">a la date </font>';
      echo "$dateRep ";
      echo '<font color="red">a changer de numero de spectacle et devient le noSpec: </font>';
      echo "$newNumS";
      
      
      
  if (isset($_POST['date']) AND isset($_POST['heure']) and !isset($_POST['NewnoSpec'])){
    echo "modification du numero de spectacle (changement d'affiche)1";
  //UPDATE lesRepresentations SET noSpec = $_POST['NewnoSpec']  WHERE noSpec=$noSpec AND dateRep=$dateRep 
  }
  else {
  echo "modification de la date de representation (changement de date) et du numero de spectacle (changement d'affiche)3";
  //a voir
  }
  
  echo "</table>";
  $noSpec = $_POST['categorie'];
  */
  include('pied.php');
?>