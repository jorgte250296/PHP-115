<?php require_once "../inc/header.php" ?>
<section>
  <h1>Opprett en ny interesse</h1>
  <form action="opprettInteresse.php" method="post">

    <label>Fyll ut</label>
    <input type="text" name="interesseNavn" required>

    <button type="submit" href="interessedisplay.php">Legg til i systemet </button>
  </form>
</section>

<?php
include_once "visning4.php";
//Validering av bruker 
require_once "../inc/validering.php";

//Hvis form action = POST kjøres innhold
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //Tilkobling database
  require_once "../inc/db.inc.php";

  //Definerer variabler
  $intersse_navn = $_POST["interesseNavn"];

  //prepared statement og klargjøring
  $pst = "INSERT INTO intrests (intrest_name) VALUES (:interesseNavn)";
  $Spørring = $pdo->prepare($pst);
  $Spørring->bindParam(':interesseNavn', $intersse_navn, PDO::PARAM_STR);

  try {
    //Prøver å kjøre spørringen mot db
    $Spørring->execute();
    echo "Interessen er nå lagt til i systemet og det er videre mulig å legge den til hos et medlem.";
  } catch (PDOException $e) {
    //feilmelding som skrives ut hvis spørring feiler
    //echo $e->getMessage();
    echo "Ops, det har skjedd en feil. Interessen er ikke lagt til i systemet.";
  }
}
?>

<?php require_once "../inc/footer.php" ?>