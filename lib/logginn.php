<?php
// Starter sesjon
session_start();

//validering
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
   header("location: velkommen.php");
    exit;
}

//Tilkobling database
require_once "..\inc\db.inc.php";

//Definerer variabler
$brukernavn = $passord = "";
$brukernavn_err = $passord_err = $login_err = "";

//Hvis form action = POST kjøres innhold
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Sjekker utfylling av brukernavn 
    if (empty(trim($_POST["brukernavn"]))) {
        $brukernavn_err = "Skriv inn brukernavn.";
    } else {
        $brukernavn = trim($_POST["brukernavn"]);
    }

    //Sjekker utfylling av passord
    if (empty(trim($_POST["passord"]))) {
        $passord_err = "Skriv inn passord.";
    } else {
        $passord = trim($_POST["passord"]);
    }

    //Sjekker innlogginsinformasjon mot db
    if (empty($brukernavn_err) && empty($passord_err)) {

        //prepared statement og klargjøring
        $pst = "SELECT * FROM users WHERE email = :bruker_email";
        $spørring = $pdo->prepare($pst);
        $spørring->bindParam(':bruker_email', $brukernavn, PDO::PARAM_STR);

        try {
            //Prøver å kjøre spørringen mot db
            $spørring->execute();
        } catch (PDOException $e) {
            //Eventuell feilmelding
            //echo $e->getMessage();
        }
        //Lagrer resultatet som objekter i en array
        $resultater = $spørring->fetchAll(PDO::FETCH_OBJ);
        if ($spørring->rowCount() > 0) {
            foreach ($resultater as $resultat) {
                $id = $resultat->user_id;
                $brukernavn = $resultat->email;
                $hashed_passord = $resultat->password;
                $navn = $resultat->$name;
            }
            //Sjekker passord
            if (password_verify($passord, $hashed_passord)) {

                // Lagrer data i session variabler
                $_SESSION["loggedin"] = true;
                $_SESSION["user_id"] = $id;
                $_SESSION["email"] = $brukernavn;
                $_SESSION["name"] = $navn;
                

                // Sender så brukeren videre til velkommen siden
                header("location: velkommen.php");
            } else {
                $login_err = "Feil brukernavn eller passord.";
            }
        } else {
            echo "Feil brukernavn eller passord.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Innlogging</title>
    <link rel="stylesheet" href="../css/main.css">
</head>

<body>
    <section>
        <h2>Logg inn</h2>
        <?php
        //Feilmelding hvis innlogging er feil
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>
        <form action="logginn.php" method="post">
            <label>Brukernavn</label>
            <input type="text" name="brukernavn" required placeholder="Skriv inn brukernavn..">
            <span class="feedback"><?php echo $brukernavn_err; ?></span>
            <br>
            <label>Passord</label>
            <input type="password" name="passord" required placeholder="Skriv inn passord..">
            <span class="feedback"><?php echo $passord_err; ?></span>
            <input type="submit" href="velkommen.php" class="btn"></input>
            <p>Trenger du konto? <a href="registrerBruker.php">Registrer deg her</a>.</p>
        </form>
        </div>
</body>

</html>