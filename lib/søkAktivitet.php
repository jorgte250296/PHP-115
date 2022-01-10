<?php require_once "../inc/header.php" ?>
<section>
  <h2>Se medlemmer som deltar på aktivitet</h2>
  <form action="søkAktivitet.php" method="post">

    <label>Søk etter aktivitet</label>
    <input type="text" name="sw" required>

    <button type="submit">Søk </button>
  </form>
</section>
<?php
//Validering av bruker 
require_once "../inc/validering.php";

//Hvis form action = POST kjøres innhold
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //Tilkobling database
  require_once "../inc/db.inc.php";

  //Definerer variabler
  $søkeord = $_POST["sw"];

  //prepered statement og klargjøring
  $pst = "SELECT M.firstname, M.lastname, A.activity_name FROM members AS M 
  JOIN activity_overview AS AO ON M.member_id = AO.member_id 
  JOIN activities AS A	ON AO.activity_id = A.activity_id WHERE A.activity_name = :sw";
  $Spørring = $pdo->prepare($pst);
  $Spørring->bindParam(':sw', $søkeord, PDO::PARAM_STR);

  try {
    //Prøver å kjøre spørringen mot db
    $Spørring->execute();
  } catch (PDOException $e) {
    //feilmelding som skrives ut hvis spørring feiler
    //echo $e->getMessage();
  }
  //Lagrer resultatet som objekter i en array
  $resutalter = $Spørring->fetchAll(PDO::FETCH_OBJ);
  if ($Spørring->rowCount() > 0) {
    echo ('<h2>Sortert etter aktivitet</h2><table border="1">');
    echo ('<th>Fornavn</th>' . '<th>Etternavn</th>' . '<th>Aktivitet</th>');
    //Kjører metoder på objektene for å få ønsket data
    foreach ($resutalter as $resultat) {
      echo ('<tr><td>' . $resultat->firstname);
      echo ('</td><td>' . $resultat->lastname);
      echo ('</td><td>' . $resultat->activity_name);
      echo ('</td></tr>');
    }
    //Skriver ut tabell
    echo ('</table>');
    include_once "visning2.php";

  } else {
    echo "Spørringen returnerte ingen oppføringer";
  }
}

?>
<?php require_once "../inc/footer.php" ?>