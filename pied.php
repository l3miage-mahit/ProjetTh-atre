<?php
   // fin de la page

   if(isset($lien) && $lien) { // on ferme la connexion Oracle √©ventuellement ouverte
      Deconnexion ($lien);
   }
?>

</body>
</html>