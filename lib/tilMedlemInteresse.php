<?php require_once "../inc/header.php" ?>
<section>
  <h1>Gi medlem en ny interesse</h1>
  <form action="tilMedlemInteresse.php" method="post">

    <label>Medlems ID</label>
    <input type="text" name="medlemsID" required>

    <label>Navn på interesse</label>
    <input type="text" name="interesseNavn" required>

    <button type="submit" href="displayInteresse.php">Legg til </button>

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
  $interesse__navn = $_POST["interesseNavn"];
  $medlems_id =    $_POST["medlemsID"];

  //prepared statement og klargjøring
  $pst = "SELECT intrest_id FROM intrests WHERE intrest_name = :interesseNavn";
  $spørring = $pdo->prepare($pst);
  $spørring->bindParam(':interesseNavn', $interesse__navn, PDO::PARAM_STR);

  try {
    //Prøver å kjøre spørringen mot db
    $spørring->execute();
  } catch (PDOException $e) {
    //feilmelding som skrives ut hvis spørring feiler
    //echo $e->getMessage();
  }


  //Lagrer resultatet som objekter i en array
  $resultater = $spørring->fetchAll(PDO::FETCH_OBJ);
  if ($spørring->rowCount() > 0) {
    foreach ($resultater as $resultat) {
      $resultat = $resultat->intrest_id;
    }
  }

  //prepared statement og klargjøring
  $pst = "INSERT INTO intrest_overview (intrest_id, member_id) VALUES (:interesseID, :medlemsID)";
  $spørring = $pdo->prepare($pst);
  $spørring->bindParam(':interesseID', $resultat, PDO::PARAM_STR);
  $spørring->bindParam(':medlemsID', $medlems_id, PDO::PARAM_STR);

  try {
      //Prøver å kjøre spørringen mot db
      $spørring->execute();
    echo "så bra! medlem nr " . $medlems_id . " har nå fått interesse: " . $interesse__navn;
  } catch (PDOException $e) {
    //feilmelding som skrives ut hvis spørring feiler
    //echo $e->getMessage();
    echo "Oisann, noe gikk galt";
  }
}
?>
<?php require_once "../inc/footer.php" ?>