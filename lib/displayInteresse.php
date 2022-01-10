<?php require_once "../inc/header.php" ?>

<title>Interesser</title>
</head>

   <table>
      </tr>

      <?php
      //Validering av bruker og tilkobling database
      require_once "../inc/validering.php";
      require_once "../inc/db.inc.php";

      //prepered statement og klargjøring
      $pst = "SELECT * from intrests";
      $Spørring = $pdo->prepare($pst);

      try {
         //Prøver å kjøre spørringen mot db
         $Spørring->execute();
      } catch (PDOException $e) {
         //Fanger eventuelle feil
         //echo $e->getMessage();
      }
      //Lagrer resultatet som objekter i en array
      $interesser = $Spørring->fetchAll(PDO::FETCH_OBJ);
      if ($Spørring->rowCount() > 0) {
         echo ('<table border="1">');
         echo ('<th>Interesse nummer</th>' . '<th>Interesse navn</th>');
         //Går igjennom listen av objekter
         foreach ($interesser as $interesse) {
            //Kjører metoder på objektene for å få ønsket data
            echo ('<tr><td>' . $interesse->intrest_id);
            echo ('</td><td>' . $interesse->intrest_name);
            echo ('</td></tr>');
         }
         //Skriver ut tabell
         echo ('</table>');

         include_once "visning4.php";
      } else {
         echo "Foreløpig ingen interesser lagt til i systemet";
      }
      ?>

      <?php require_once "../inc/footer.php" ?>