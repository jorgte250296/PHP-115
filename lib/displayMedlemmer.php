<?php require_once "../inc/header.php" ?>

<title>Medlemmer</title>
</head>

<table>
  </tr>

  <?php
  //Validering av bruker og tilkobling database
  require_once "../inc/validering.php";
  require_once "../inc/db.inc.php";

  //prepered statement og klargjøring
  $pst = "SELECT * FROM members";
  $Spørring = $pdo->prepare($pst);

  try {
    //Prøver å kjøre spørringen mot db
    $Spørring->execute();
  } catch (PDOException $e) {
    //Eventuell feilmelding
    //echo $e->getMessage();
  }

  //Lagrer resultatet som objekter i en array
  $medlemmer = $Spørring->fetchAll(PDO::FETCH_OBJ);
  if ($Spørring->rowCount() > 0) {
    echo ('<th>Medlems ID</th>' .
      '<th>Fornavn</th>' .
      '<th>Etternavn</th>' .
      '<th>Fødselsdato</th>' .
      '<th>Kjønn</th>' .
      '<th>Gatenavn</th>' .
      '<th>Postkode</th>' .
      '<th>Poststed</th>' .
      '<th>Mobilnummer</th>' .
      '<th>E-post</th>' .
      '<th>Aktiv siden</th>' .
      '<th>Kontigentstatus</th>');



    //Går igjennom listen av objekter
    foreach ($medlemmer as $medlem) {

      //Kjører metoder på objektene for å få ønsket data      
      echo ('<tr><td>' . $medlem->member_id);
      echo ('</td><td>' . $medlem->firstname);
      echo ('</td><td>' . $medlem->lastname);
      echo ('</td><td>' . $medlem->date_of_birth);
      echo ('</td><td>' . $medlem->sex);
      echo ('</td><td>' . $medlem->address);
      echo ('</td><td>' . $medlem->postalcode);
      echo ('</td><td>' . $medlem->postalarea);
      echo ('</td><td>' . $medlem->mobilenumber);
      echo ('</td><td>' . $medlem->email);
      echo ('</td><td>' . $medlem->active_since);
      echo ('</td><td>' . $medlem->contingent);
      echo ('</td></tr>');
    }
    //Skriver ut tabellen
    echo ('</table>');

    include_once "visning1.php";
  } else {
    echo "Det er ingen medlemmer i systemet til NEO, på tide å rekruttere";
  }


  ?>

  <?php require_once "../inc/footer.php" ?>