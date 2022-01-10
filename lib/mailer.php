<?php require_once "../inc/header.php" ?>
<section>
  <h1>Send mail til medlem</h1>
  <form action="mailer.php" method="post">

    <label>mottaker navn</label>
    <input type="text" name="mottakerNavn" />

    <label>Til email</label>
    <input type="text" name="mottakerMail" />

    <label>Tema</label>
    <input type="text" name="emne" />

    <label>Melding</label>
    <textarea type="text" name="innhold" cols="60" rows="10"></textarea>
    <button type="submit">Send mail </button>
  </form>
</section>

<?php
require_once "../inc/validering.php";

//Henter ressurser fra PHP-mailer
require_once '../ressurser/PHPMAILER/src/Exception.php';
require_once '../ressurser/PHPMAILER/src/PHPMailer.php';
require_once '../ressurser/PHPMAILER/src/SMTP.php';

//Oppretter et nytt objekt fra PHPMaier klasse
$mail = new PHPMailer\PHPMailer\PHPMailer();

//Hvis form action = POST kjøres innhold
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
  //Tilkobling database
  include_once "../inc/db.inc.php";

  //Definerer variabler
  $mottaker_navn = $_POST["mottakerNavn"];
  $avsender_navn = $_SESSION["name"];
  $tema = $_POST["emne"];
  $innhold = $_POST["innhold"];
  $avsender_mail = "phpuia30@gmail.com";
  $mottaker_mail = $_POST["mottakerMail"];;

  try {
    // Autorisering
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls"; // påkrevd for Gmail
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
    echo "E-post er sendt";
  } catch (Exception $e) {
    //Feilmelding
    echo "Noe gikk galt: " . $e->getMessage();
  }
}
?>

<?php include_once "../inc/footer.php"; ?>