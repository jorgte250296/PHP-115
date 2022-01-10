<?php require_once "../inc/header.php" ?>

<?php
//Validering av bruker og tilkobling database
require_once "../inc/validering.php";
require_once "../inc/db.inc.php";

//prepered statement og klargjøring
$pst = "SELECT * FROM activities WHERE end > CURRENT_TIMESTAMP()";
$Spørring = $pdo->prepare($pst);

try {
  //Prøver å kjøre spørringen mot db
  $Spørring->execute();
} catch (PDOException $e) {
  //feilmelding som skrives ut hvis spørring feiler
  //echo $e->getMessage();
}

//Lagrer resultatet som objekter i en array
$aktiviteter = $Spørring->fetchAll(PDO::FETCH_OBJ);
if ($Spørring->rowCount() > 0) {
  echo ('<h2>Kommende aktiviteter</h2><table border="1">');
  echo ('<th>Aktivitet navn</th>' . '<th>Start</th>' . '<th>Slutt</th>');
  //Går igjennom listen av objekter
  foreach ($aktiviteter as $aktivitet) {
    //Kjører metoder på objektene for å få ønsket data
    echo ('<tr><td>' . $aktivitet->activity_name);
    echo ('</td><td>' . $aktivitet->start);
    echo ('</td><td>' . $aktivitet->end);
    echo ('</td></tr>');
  }
  //Skriver ut tabell
  echo ('</table>');

  include_once "visning2.php";
} else {
  echo "Det er ingen kommende aktiviteter.";
}
?>
<?php require_once "../inc/footer.php" ?>
