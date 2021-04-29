<?php

	$titre = 'AJOUT Representation';
	include('entete.php');

	      

if (!isset($_POST['date']) and !isset($_POST['heure'])){
        echo '<span style="color:red;">  il manque le noSpec (numero de specacle) </span>';
        echo '  recommance en saisissant le numero la date et l\'heure';
}
else{
    $noSpec=$_POST['categorie'];
    $date=$_POST['date'];
    $heure=$_POST['heure'];
    // construction des requêtes
	  $requete = "INSERT INTO LesRepresentations values (to_date('$date $heure', 'DD-MM-YYYY HH24:MI'),$noSpec)";
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

			echo LeMessage ("majOK") ;
			// terminaison de la transaction : validation
			oci_commit ($lien) ;

		}

	// on libère le curseur
	oci_free_statement($curseur);
}
	include('pied.php');

?>
