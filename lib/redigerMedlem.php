<?php include_once "../inc/header.php"; ?>

<section>
    <h2>Oppdater medlemsinformasjon</h2>
    <form action="redigerMedlem.php" method="post">
        <label>Fyll inn Medlems ID til medlem du ønsker endre</label>
        <input type="text" name="medlemsID" required>

        <label>Hvilken attributt vil du endre?</label>
        <input type="text" name="ønsketFelt" required>

        <label>Hva vil du endre den til?</label>
        <input type="text" name="nyFeltVerdi" required>

        <button type="submit" href="displayMedlemmer.php">Legg til </button>
    </form>
</section>

<?php
include_once "visning1.php";

//Hvis form action = POST kjøres innhold
require_once "../inc/validering.php";

//Hva som kommer om man har en POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Tilkobling database
    require_once "../inc/db.inc.php";

    //Definerer variabler
    $medlems_id = $_POST["medlemsID"];
    $gammel_data = $_POST["ønsketFelt"];
    $ny_data = $_POST["nyFeltVerdi"];

    //Switch statement med ulike caser: Gjør det mulig å fokusere på et felt i en tabellen ved søk
    switch ($gammel_data) {
        case ($gammel_data == "medlemsid"):
            $gammel_data = "member_id";
            break;
        case ($gammel_data == "fornavn"):
            $gammel_data = "firstname";
            break;
        case ($gammel_data == "etternavn"):
            $gammel_data = "lastname";
            break;
        case ($gammel_data == "fødselsdato"):
            $gammel_data = "date_of_birth";
            break;
        case ($gammel_data == "kjønn"):
            $gammel_data = "sex";
            break;
        case ($gammel_data == "adresse"):
            $gammel_data = "address";
            break;
        case ($gammel_data == "postkode"):
            $gammel_data = "postalcode";
            break;
        case ($gammel_data == "poststed"):
            $gammel_data = "postalarea";
            break;
        case ($gammel_data == "mobilnummer"):
            $gammel_data = "mobilenumber";
            break;
        case ($gammel_data == "email"):
            $gammel_data = "email";
            break;
        case ($gammel_data == "aktivsiden"):
            $gammel_data = "active_since";
            break;
        case ($gammel_data == "kontigent"):
            $gammel_data = "contingent";
            break;
    }

    //prepered statement og klargjøring
    $pst = "UPDATE members SET $gammel_data = :nyData WHERE member_id = :medlemsID";
    $spørring = $pdo->prepare($pst);
    $spørring->bindParam(':medlemsID', $medlems_id, PDO::PARAM_STR);
    $spørring->bindParam(':nyData', $ny_data, PDO::PARAM_STR);

    try {
        //Prøver å kjøre spørringen mot db
        $spørring->execute();
        echo "$gammel_data er nå endret til $ny_data for medlem nr: $medlems_id";
    } catch (PDOException $e) {
        //feilmelding som skrives ut hvis spørring feiler
        //echo $e->getMessage();
        echo "Noe gikk galt <br>";
    }
}

?>

<?php include_once "../inc/footer.php"; ?>