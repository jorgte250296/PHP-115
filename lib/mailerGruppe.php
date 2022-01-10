<?php include_once "../inc/header.php"; ?>

<section>
  <h1>Gruppemail</h1>
  <form action="mailerGruppe.php" method="post">

    <label>Parameter for søk <br>(Må være samme som navn på kolonne i database)</label>
    <input type="text" name="parameterSøk" />

    <label>Fyll inn ønsket verdi i kolonne <br> (Eks. "mann" for kjønn)</label>
    <input type="text" name="sw" />

    <label>Tema</label>
    <input type="text" name="emne" />

    <label>Melding</label>
    <textarea type="text" name="innhold" cols="60" rows="10"></textarea>
    <button type="submit">Send mail </button>
  </form>
</section>

<?php
function søkefunksjonmail($søkeparameter, $søkeord)
{
  //Tilkobling database
  include_once "../inc/db.inc.php";

  //Prepered statment for å få ønsket resultat grupert med interesser
  $pst = "SELECT email FROM members WHERE $søkeparameter = :sw";

  // Forbereder spørring
  $spørring = $pdo->prepare($pst);
  $spørring->bindParam(':sw', $søkeord, PDO::PARAM_STR);

  try {
    //Prøver å kjøre spørringen
    $spørring->execute();
  } catch (PDOException $e) {
    //Fanger eventuelle feil
    echo /*$e->getMessage() .*/ "<br>";
  }

  $medlemmer = array();
  //Kjører metoder i en loop på objektene for å få ønsket resultat i tabellen
  $resultater = $spørring->fetchAll(PDO::FETCH_OBJ);
  if ($spørring->rowCount() > 0) {
    foreach ($resultater as $resultat) {
      $medlemmer[] = $resultat->email;
    }
    return $medlemmer;
  } else {
    echo "Spørringen returnerte ingen oppføringer";
  }
}
require_once "../inc/validering.php";

//Hvis form action = POST kjøres innhold
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //Definerer variabler
  $avsender_navn = $_SESSION["name"];
  $tema = $_POST["emne"];
  $innhold = $_POST["innhold"];
  $søkeord = $_POST["sw"];
  $søkeparameter = $_POST["parameterSøk"];

  //Bruker funksjon definert ovenfor og setter resultatet i en array
  $mailtil = søkefunksjonmail($søkeparameter, $søkeord);

  foreach ($mailtil as $tilmail) {
    //Henter ressurser fra PHP-mailer
    require_once '../ressurser/PHPMAILER/src/Exception.php';
    require_once '../ressurser/PHPMAILER/src/PHPMailer.php';
    require_once '../ressurser/PHPMAILER/src/SMTP.php';

    //Oppretter et nytt objekt fra PHPMaier klasse
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $avsender_mail = "phpuia30@gmail.com";
    $mottaker_mail = $tilmail;

    try {
      // Autorisasjon
      $mail->IsSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = "tls"; //påkrevd for Gmail
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 587;
      $mail->Username = "phpuia30@gmail.com";
      $mail->Password = "Uiaphp2021";

      //Meldingstekst for HTML-mottakere
      $mail->isHTML(true);
      $mail->From = $avsender_mail;
      $mail->FromName = $avsender_navn;
      $mail->addAddress($mottaker_mail);
      $mail->Subject = $tema;

      $mld = $innhold;
      $mail->Body = $mld;

      //Sender
      $mail->send();

      //Bekreftelse
      echo "E-post er sendt til: <br> $tilmail, ";
    } catch (Exception $e) {
      //Feilmelding
      echo "Noe gikk galt: " . $e->getMessage();
    }
  }
}

?>