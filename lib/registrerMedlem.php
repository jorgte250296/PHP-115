<?php require_once "../inc/header.php" ?>
<section>
  <h2>Legg til medlem</h2>
  <form action="registrerMedlem.php" method="post">

    <label>Fornavn</label>
    <input type="text" name="fornavn" required>

    <label>Etternavn</label>
    <input type="text" name="etternavn" required>

    <label>Fødselsdato</label>
    <input type="date" name="fdato" required>

    <label>Kjønn</label>
    <input type="text" name="kjoenn" required>

    <label>Addresse</label>
    <input type="text" name="adresse" required>

    <label>Postkode</label>
    <input type="text" name="postkode" required>

    <label>Poststed</label>
    <input type="text" name="poststed" required>

    <label>Mobilnummer</label>
    <input type="text" name="mobilnummer" required>

    <label>E-post</label>
    <input type="email" name="email" required>

    <label>Aktiv siden</label>
    <input type="date" name="aktivSiden" required>

    <label>Medlemsstatus/kontigent</label>
    <input type="text" name="medlemsKontigent" required>

    <button type="submit">Legg til </button>
  </form>
</section>

<?php
include_once "visning1.php";

//Validering av bruker 
require_once "../inc/validering.php";

//Hvis form action = POST kjøres innhold
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //Definerer variabler
  $fornavn = $_POST["fornavn"];
  $etternavn = $_POST["etternavn"];
  $foedselsdato = $_POST["fdato"];
  $kjoen = $_POST["kjoenn"];
  $adresse = $_POST["adresse"];
  $postkode = $_POST["postkode"];
  $poststed = $_POST["poststed"];
  $mobilnummer = $_POST["mobilnummer"];
  $email = $_POST["email"];
  $aktiv_siden = $_POST["aktivSiden"];
  $kontigent = $_POST["medlemsKontigent"];

  require_once "../inc/db.inc.php";

  //prepered statement og klargjøring
  $pst = "INSERT INTO members (firstname, lastname, date_of_birth, sex, address, postalcode, postalarea, mobilenumber, email, active_since, contingent) VALUES (:fornavn, :etternavn, :fdato, :kjoenn, :adresse , :postkode , :poststed, :mobilnummer , :email , :aktivSiden, :medlemsKontigent)";
  $spørring = $pdo->prepare($pst);
  $spørring->bindParam(':fornavn', $fornavn, PDO::PARAM_STR);
  $spørring->bindParam(':etternavn', $etternavn, PDO::PARAM_STR);
  $spørring->bindParam(':fdato', $foedselsdato, PDO::PARAM_STR);
  $spørring->bindParam(':kjoenn', $kjoen, PDO::PARAM_STR);
  $spørring->bindParam(':adresse', $adresse, PDO::PARAM_STR);
  $spørring->bindParam(':postkode', $postkode, PDO::PARAM_STR);
  $spørring->bindParam(':poststed', $poststed, PDO::PARAM_STR);
  $spørring->bindParam(':mobilnummer', $mobilnummer, PDO::PARAM_STR);
  $spørring->bindParam(':email', $email, PDO::PARAM_STR);
  $spørring->bindParam(':aktivSiden', $aktiv_siden, PDO::PARAM_STR);
  $spørring->bindParam(':medlemsKontigent', $kontigent, PDO::PARAM_STR);


  try {
    //Prøver å kjøre spørringen mot db
    $spørring->execute();
    require_once "funksjonLogg.php";

    echo "Så bra! medlemmet er lagt til i NEO.";
  } catch (PDOException $e) {
    //feilmelding som skrives ut hvis spørring feiler
    //echo $e->getMessage();
    echo "Medlemmet ble desverre ikke lagt til.";
  }
}
?>
<?php require_once "../inc/footer.php" ?>