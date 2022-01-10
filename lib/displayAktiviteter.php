<?php require_once "../inc/header.php" ?>

<title>Aktiviteter</title>
<table>
    </tr>

    <?php
    //Validering av bruker og tilkobling database
    require_once "../inc/validering.php";
    require_once "../inc/db.inc.php";

    //prepered statement og klargjøring
    $pst = "SELECT * FROM activities";
    $spørring = $pdo->prepare($pst);

    try {
        //Prøver å kjøre spørringen mot db
        $spørring->execute();
    } catch (PDOException $e) {
        //feilmelding som skrives ut hvis spørring feiler
        //echo $e->getMessage();
    }
    //Lagrer resultatet som objekter i en array
    $aktiviteter = $spørring->fetchAll(PDO::FETCH_OBJ);
    if ($spørring->rowCount() > 0) {
        echo ('<table border="1">');
        echo ('<th>Aktivitet id</th>' . '<th>Aktivitets navn</th>' . '<th>Ansvarlig</th>' . '<th>Start</th>' . '<th>Slutt</th>');
        //Går igjennom listen av objekter
        foreach ($aktiviteter as $aktivitet) {
            //Kjører metoder på objektene for å få ønsket data      
            echo ('<tr><td>' . $aktivitet->activity_id);
            echo ('</td><td>' . $aktivitet->activity_name);
            echo ('</td><td>' . $aktivitet->responsible);
            echo ('</td><td>' . $aktivitet->start);
            echo ('</td><td>' . $aktivitet->end);
            echo ('</td></tr>');
        }
        //Skriver ut tabellen
        echo ('</table>');
        include_once "visning2.php";

    } else {
        echo "Det er per dags dato ikke lagt inn noen medlemmer i systemet til Neo";
    }
    ?>
</table>
<?php require_once "../inc/footer.php" ?>