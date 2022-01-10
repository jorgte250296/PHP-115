<?php require_once "../inc/header.php" ?>

<section>
  <h2>Lag ny aktivitet</h2>
  <form action="opprettAktivitet.php" method="post">

    <label>Aktivitetsnavn</label>
    <input type="text" name="aktivitetNavn" required>

    <label>Ansvarlig</label>
    <input type="text" name="ansvarlig" required>

    <label>Start</label>
    <input type="datetime-local" name="start" required>

    <label>Slutt</label>
    <input type="datetime-local" name="slutt" required>

    <button type="submit" href="aktivitetdisplay.php">Legg til </button>
  </form>
</section>

<?php
include_once "visning2.php";
//Validering av bruker 
require_once "../inc/validering.php";

//Hvis form action = POST kjøres innhold
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //Tilkobling database
  require_once "../inc/db.inc.php";

  //Definerer variabler
  $activityname   = $_POST["aktivitetNavn"];
  $responsible    = $_POST["ansvarlig"];
  $start          = $_POST["start"];
  $end            = $_POST["slutt"];

  //prepared statement og klargjøring
  $pst = "INSERT INTO activities (activity_name, responsible, start, end) VALUES (:aktivitetNavn, :ansvarlig, :start, :slutt)";
  $Spørring = $pdo->prepare($pst);
  $Spørring->bindParam(':aktivitetNavn', $activityname, PDO::PARAM_STR);
  $Spørring->bindParam(':ansvarlig', $responsible, PDO::PARAM_STR);
  $Spørring->bindParam(':start', $start, PDO::PARAM_STR);
  $Spørring->bindParam(':slutt', $end, PDO::PARAM_STR);

  try {
    //Prøver å kjøre spørringen mot db
    $Spørring->execute();
    echo "Aktivitet er oppført i NEO sitt system.";
  } catch (PDOException $e) {
    //feilmelding som skrives ut hvis spørring feiler
    //echo $e->getMessage();
    echo "Aktivitet er ikke opprettet, problemer med systemet";
  }
}
?>

<?php require_once "../inc/footer.php" ?>