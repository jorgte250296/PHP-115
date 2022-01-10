<?php require_once "../inc/header.php" ?>

<section>
  <h1>Tildel medlem rolle</h1>
  <form action="tilMedlemRolle.php" method="post">

    <label>Medlems ID</label>
    <input type="text" name="medlemsID" required>

    <label>Fyll inn navn på rolle</label>
    <input type="text" name="rolle" required><br>

    <button type="submit">Legg til </button>
  </form>
</section>
<?php
include_once "visning1.php";

//Validering av bruker 
require_once "../inc/validering.php";

//Hvis form action = POST kjøres innhold
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //Tilkobling database
  require_once "../inc/db.inc.php";

  //Definerer variabler
  $medlems_id  =   $_POST["medlemsID"];
  $rolle_navn   =   $_POST["rolle"];

  //prepered statement og klargjøring
  $pst = "SELECT role_id FROM roles WHERE role_name = :rollenavn";
  $Spørring = $pdo->prepare($pst);
  $Spørring->bindParam(':rollenavn', $rolle_navn, PDO::PARAM_STR);

  try {
    //Prøver å kjøre spørringen mot db
    $Spørring->execute();
  } catch (PDOException $e) {
    //feilmelding som skrives ut hvis spørring feiler
    //echo $e->getMessage();
  }


  //Lagrer resultatet som objekter i en array
  $resultater = $Spørring->fetchAll(PDO::FETCH_OBJ);
  if ($Spørring->rowCount() > 0) {
    foreach ($resultater as $resultat) {
      $resultat = $resultat->role_id;
    }
  }

  //prepared statement og klargjøring
  $pst = "INSERT INTO role_overview (role_id, member_id) VALUES (:rolleID, :medlemsID)";
  $Spørring = $pdo->prepare($pst);
  $Spørring->bindParam(':rolleID', $resultat, PDO::PARAM_STR);
  $Spørring->bindParam(':medlemsID', $medlems_id, PDO::PARAM_STR);

  try {
    //Prøver å kjøre spørringen mot db
    $Spørring->execute();
    echo "medlemnr" . $medlems_id . "har nå fått en ny rolle.";
  } catch (PDOException $e) {
    //feilmelding som skrives ut hvis spørring feiler
    //echo $e->getMessage();
    echo "Oisann, noe gikk galt";
  }
}
?>
<?php require_once "../inc/footer.php" ?>