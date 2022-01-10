<?php require_once "../inc/header.php" ?>
<section>
    <h2>Søk etter felt med lik verdi</h2>
    <form action="søkAvansert.php" method="post">

        <label>Skriv inn kategori for medlemsinformasjon, rolle, aktivitet eller interesse</label>
        <input type="text" name="databaseFelt" required>

        <label>Innhold i felt</label>
        <input type="text" name="sw" required>

        <button type="submit">Legg til </button>
    </form>
</section>
<?php

//Validering av bruker 
require_once "../inc/validering.php";

//Hvis form action = POST kjøres innhold
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../inc/db.inc.php";

    //Definerer variabler
    $felt_database =  $_POST["databaseFelt"];
    $søkeord = $_POST["sw"];
    //Switch statement med ulike caser: Gjør det mulig å fokusere på et felt i en tabellen ved søk
    switch ($felt_database) {
        case ($felt_database == "medlemsid" || $felt_database == "id"):
            $felt_database = "member_id";
            break;
        case ($felt_database == "fornavn"):
            $felt_database = "firstname";
            break;
        case ($felt_database == "etternavn"):
            $felt_database = "lastname";
            break;
        case ($felt_database == "fødselsdato"):
            $felt_database = "date_of_birth";
            break;
        case ($felt_database == "kjønn"):
            $felt_database = "sex";
            break;
        case ($felt_database == "adresse"):
            $felt_database = "address";
            break;
        case ($felt_database == "postkode"):
            $felt_database = "postalcode";
            break;
        case ($felt_database == "poststed" || $felt_database == "post sted"):
            $felt_database = "postalarea";
            break;
        case ($felt_database == "mobilnummer"):
            $felt_database = "mobilenumber";
            break;
        case ($felt_database == "email"):
            $felt_database = "email";
            break;
        case ($felt_database == "aktivsiden"):
            $felt_database = "active_since";
            break;
        case ($felt_database == "kontigent"):
            $felt_database = "contingent";
            break;
        case ($felt_database == "aktivitet" || $felt_database == "aktivitetnavn" || $felt_database == "aktivitetsnavn"):
            $felt_database = "activity_name";
            break;
        case ($felt_database == "interesse" || $felt_database == "interessenavn"):
            $felt_database = "intrest_name";
            break;
        case ($felt_database == "rolle" || $felt_database == "rollenavn"):
            $felt_database = "role_name";
            break;
    }
    //Validering av bruker og tilkobling database
    $pst = "SELECT M.member_id, M.firstname, M.lastname, M.contingent, A.activity_name, I.intrest_name, R.role_name
        FROM members AS M 
	    LEFT JOIN activity_overview AS AO ON AO.member_id = M.member_id 
	    LEFT JOIN activities AS A ON AO.activity_id = A.activity_id
	    LEFT JOIN intrest_overview AS IO ON IO.member_id = M.member_id 
	    LEFT JOIN intrests AS I ON IO.intrest_id = I.intrest_id 
	    LEFT JOIN role_overview AS RO ON RO.member_id = M.member_id 
	    LEFT JOIN roles AS R ON RO.role_id = R.role_id
        WHERE $felt_database = :sw";

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
        foreach ($resultater as $resultat) {
            if (!empty($resultat->member_id)) {
                $header = '<th>Medlems id</th>';
            }
            if (!empty($resultat->firstname)) {
                $header .= '<th>Fornavn</th>';
            }
            if (!empty($resultat->lastname)) {
                $header .= '<th>Etternavn</th>';
            }
            if (!empty($resultat->contingent)) {
                $header .= '<th>Kontigent</th>';
            }
            if (!empty($resultat->activity_name)) {
                $header .= '<th>Aktiviteter</th>';
            }
            if (!empty($resultat->intrest_name)) {
                $header .= '<th>Interesser</th>';
            }
            if (!empty($resultat->role_name)) {
                $header .= '<th>Rolle navn</th>';
            }
        }
        echo ('<h2>Sortert etter interesse</h2><table border="1">');
        echo $header;
        //Kjører metoder i en loop på objektene for å få ønsket resultat i tabellen
        foreach ($resultater as $resultat) {
            if (!empty($resultat->member_id)) {
                echo ('<tr><td>' . $resultat->member_id);
            }
            if (!empty($resultat->firstname)) {
                echo ('</td><td>' . $resultat->firstname);
            }
            if (!empty($resultat->lastname)) {
                echo ('</td><td>' . $resultat->lastname);
            }
            if (!empty($resultat->contingent)) {
                echo ('</td><td>' . $resultat->contingent);
            }
            if (!empty($resultat->activity_name)) {
                echo ('</td><td>' . $resultat->activity_name);
            }
            if (!empty($resultat->intrest_name)) {
                echo ('</td><td>' . $resultat->intrest_name);
            }
            if (!empty($resultat->role_name)) {
                echo ('</td><td>' . $resultat->role_name);
            }
            echo ('</td></tr>');
        }
        echo ('</table>');
        include_once "visning1.php";

    } else {
        echo "Spørringen returnerte ingen oppføringer";
    }
}
?>

<?php require_once "../inc/footer.php" ?>