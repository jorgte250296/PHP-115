<?php require_once "../inc/header.php" ?>
<section>
  <h2>Legg til ny rolle</h2>
  <form action="opprettRolle.php" method="post">

    <section>Rolle</section>
    <input type="text" name="rollenavn" required><br>

    <button type="submit" href="displayRolle.php">Legg til </button>
  </form>
</section>
<?php
include_once "visning3.php";

//Validering av bruker 
require_once "../inc/validering.php";

//Hvis form action = POST kjøres innhold
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //Tilkobling database
  require_once "../inc/db.inc.php";

  //Definerer variabler
  $rolle = $_POST["rollenavn"];

  //prepered statement og klargjøring
  $pst = "INSERT INTO roles (role_name) VALUES (:rollenavn)";
  $spørring = $pdo->prepare($pst);
  $spørring->bindParam(':rollenavn', $rolle, PDO::PARAM_STR);

  try {
    //Prøver å kjøre spørringen mot db
    $spørring->execute();
    echo "Rolle er nå opprettet";
  } catch (PDOException $e) {
    //feilmelding som skrives ut hvis spørring feiler
    echo $e->getMessage();
    echo "Rolle ble ikke opprettet";
  }
}
?>

<?php require_once "../inc/footer.php" ?>