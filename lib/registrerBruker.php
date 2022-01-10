
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Innlogging</title>
    <link rel="stylesheet" href="../css/main.css">
</head>

<body>
    <section>
        <h1>Registrer deg</h1>
        <form action="registrerBruker.php" method="post">
            <label>Email</label>
            <input type="email" name="mail" required>
            <br>
            <label>Passord</label>
            <input type="password" name="passord" required>
            <br>
            <label>navn til bruker</label>
            <input type="text" name="navnbruker" required>
            <br>
            <input type="submit" class="btn" value="Registrer">
            <br>
            <p>Allerede registrert? <a href="logginn.php">Logg inn her</a>.</p>
        </form>
    </section>


    <?php

    function alert($msg)
    {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }


    //Hvis form action = POST kjøres innhold
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //Tilkobling database
        include_once "../inc/db.inc.php";
        $param_brukernavn = $_POST["mail"];
        $param_passord = $_POST["passord"];
        $param_navnbruker =  $_POST["navnbruker"];

  //Definerer variabler
  $brukernavn = $passord = $navnbruker = "";

        // Sjekker brukernavnet
        if (empty(trim($param_brukernavn))) {
            alert("mail må fylles ut");
        } else {

  //prepered statement og klargjøring
  $pst = "SELECT user_id FROM users WHERE email = :mail";
            $spørring = $pdo->prepare($pst);
            $spørring->bindParam(':mail', $param_brukernavn, PDO::PARAM_STR);
        }

        try {
    //Prøver å kjøre spørringen mot db
    $spørring->execute();
        } catch (PDOException $e) {
    //feilmelding som skrives ut hvis spørring feiler
            echo $e->getMessage() . "<br>";
        }

        if (!empty($spørring->fetchAll(PDO::FETCH_OBJ))) {
            alert("E-posten er allerede i bruk.");
        } else {
            $brukernavn = trim($param_brukernavn);
        }

        //Sjekker passordet
        if (empty(trim($param_passord))) {
            alert("Fyll ut passord.");
        } elseif (strlen(trim($param_passord)) < 6) {
            alert("Passordet må bestå av 6 tegn.");
        } else {
            $passord = trim($param_passord);
        }

        //Sjekker navn
        if (empty(trim($param_navnbruker))) {
            alert("Navn må fylles ut");
        } else {
            $navnbruker = trim($param_navnbruker);
        }



  //prepered statement og klargjøring
  $pst = "INSERT INTO users (email, password, name) VALUES (:mail, :passord, :navnbruker)";
        $spørring = $pdo->prepare($pst);
        $spørring->bindParam(':mail', $param_brukernavn, PDO::PARAM_STR);
        $spørring->bindParam(':passord', $param_passord, PDO::PARAM_STR);
        $spørring->bindParam(':navnbruker', $param_navnbruker, PDO::PARAM_STR);

        //Setter variabelverdi
        $param_brukernavn = $brukernavn;
        $param_passord = password_hash($passord, PASSWORD_DEFAULT); // Lager passord hash
        $param_navnbruker = $navnbruker;

        try {
    //Prøver å kjøre spørringen mot db
            $spørring->execute();
            header("location: logginn.php");
        } catch (PDOException $e) {
            //Fanger eventuelle feil
            echo "Oisann, noe gikk visst galt." . $e->getMessage() . "<br>";
        }
    }
    ?>
