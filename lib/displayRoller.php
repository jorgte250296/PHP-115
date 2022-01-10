<?php require_once "../inc/header.php" ?>

<title>Roller</title>
</head>

<table>
   </tr>
   <?php
   //Validering av bruker og tilkobling database
   require_once "../inc/validering.php";
   include_once "../inc/db.inc.php";

   //prepered statement og klargjøring
   $pst = "SELECT * from roles";
   $Spørring = $pdo->prepare($pst);

   try {
      //Prøver å kjøre spørringen mot db
      $Spørring->execute();
   } catch (PDOException $e) {
      //Eventuell feilmelding
      //echo $e->getMessage();
   }

   //Lagrer resultatet som objekter i en array
   $roller = $Spørring->fetchAll(PDO::FETCH_OBJ);
   if ($Spørring->rowCount() > 0) {
      echo ('<table border="1">');
      echo ('<th>Rolle ID</th>' . '<th>Rolle navn</th>');

      //Går igjennom listen av objekter
      foreach ($roller as $rolle) {
         echo ('<tr><td>' . $rolle->role_id);
         echo ('</td><td>' . $rolle->role_name);
         echo ('</td></tr>');
      }

      //Skriver ut tabellen
      echo ('</table>');

      include_once "visning3.php";
   } else {
      echo "Det er foreløpig ikke lagt inn noen roller i systemet. Men dette kan enkelt gjøres";
   }
   ?>

   <?php require_once "../inc/footer.php" ?>