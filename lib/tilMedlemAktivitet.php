<?php require_once "../inc/header.php" ?>
<section>
  <h1>Meld medlem på aktivitet</h1>
  <form action="tilMedlemAktivitet.php" method="post">
    <label>Fyll inn medlems id</label>
    <input type="text" name="medlemsID" required>

    <label>Fyll inn aktivitetsnavn</label>
    <input type="text" name="aktivitetNavn" required>

    <button type="submit" href="aktivitetsøk.php">Meld på </button>
  </form>
</section>
<?php
include_once "visning1.php";
//Validering av bruker 
require_once "../inc/validering.php";

//Hvis form action = POST kjøres innhold
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //Tilkobling database
  include_once "../inc/db.inc.php";

  //Definerer variabler
  $medlems_id      = $_POST["medlemsID"];
  $aktivitet_navn   = $_POST["aktivitetNavn"];

  //prepared statement og klargjøring
  $pst = "SELECT activity_id FROM activities WHERE activity_name = :aktivitetNavn";
  $Spørring = $pdo->prepare($pst);
  $Spørring->bindParam(':aktivitetNavn', $aktivitet_navn, PDO::PARAM_STR);

  try {
    //Prøver å kjøre spørringen mot db
    $Spørring->execute();
  } catch (PDOException $e) {
    //feilmelding som skrives ut hvis spørring feiler
    //echo $e->getMessage();
  }
  //Lagrer resultatet som objekter i en array
  $aktivitet_ider = $Spørring->fetchAll(PDO::FETCH_OBJ);
  if ($Spørring->rowCount() > 0) {
    foreach ($aktivitet_ider as $aktivitet_id) {
      $aktivitet_id = $aktivitet_id->activity_id;
    }

    //prepared statement og klargjøring
    $pst = "INSERT INTO activity_overview (activity_id, member_id) VALUES (:aktivitetsID, :medlemsID)";
    $Spørring = $pdo->prepare($pst);
    $Spørring->bindParam(':aktivitetsID', $aktivitet_id, PDO::PARAM_STR);
    $Spørring->bindParam(':medlemsID', $medlems_id, PDO::PARAM_STR);

    try {
      //Prøver å kjøre spørringen mot db
      $Spørring->execute();
      echo "Supert, medlem er lagt til i " . $aktivitet_navn;
    } catch (PDOException $e) {
      //Fanger eventuelle feil
      //echo $e->getMessage();
      echo "Oisann, noe gikk galt";

    }
  }
}
?>

<?php require_once "../inc/footer.php" ?>