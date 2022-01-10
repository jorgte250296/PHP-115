<?php require_once "../inc/header.php" ?>

<section>
    <h2>Søk etter medlem ut fra hvilken rolle de besitter</h2>
    <form action="søkRolle.php" method="post">

        <label>Søk etter rolle</label>
        <input type="text" name="sw" required><br>

        <button type="submit">Søk</button>
    </form>
</section>

<?php
include_once "visning3.php";

//Validering av bruker 
require_once "../inc/validering.php";

//Hvis form action = POST kjøres innhold
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $søkeord = $_POST["sw"];

    //Tilkobling database
    require_once "../inc/db.inc.php";

    //prepered statement og klargjøring
    $pst = "SELECT M.firstname, M.lastname, R.role_name FROM members AS M 
    JOIN role_overview AS RO ON M.member_id = RO.member_id 
    JOIN roles AS R ON RO.role_id = R.role_id WHERE R.role_name = :sw";
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
    $resultater = $Spørring->fetchAll(PDO::FETCH_OBJ);
    if ($Spørring->rowCount() > 0) {
        echo ('<h2>Sortert etter rolle</h2><table border="1">');
        echo ('<th>Fornavn</th>' . '<th>Etternavn</th>' . '<th>Rolle</th>');
        //Kjører metoder på objektene for å få ønsket data
        foreach ($resultater as $resultat) {
            echo ('<tr><td>' . $resultat->firstname);
            echo ('</td><td>' . $resultat->lastname);
            echo ('</td><td>' . $resultat->role_name);
            echo ('</td></tr>');
        }
        //Skriver ut tabell
        echo ('</table>');
        include_once "visning3.php";
    }   else {
        echo "Det er ingen i NEO som har denne rollen";
    }
}
?>
<?php require_once "../inc/footer.php" ?>