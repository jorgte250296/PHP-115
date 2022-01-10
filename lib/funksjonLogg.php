<?php
function loggfunksjon($logg_tekst){
    //Directory til mappe
    $logg_dir = "../log";
    //sjekker om filen allerede eksisterer
    if (!file_exists($logg_dir)) {
        //Hvis ikke lages  mappen med filnavn med de ulike tillatelsene
        //7 står for full access
        mkdir($logg_dir, 0777, true);
    }
    //Oppretter fil eller bruker eksisterende
    $logg_fil_data = $logg_dir . '/log_' .  date('d-M-Y') . '.log';
    //Legger in dataene
    file_put_contents($logg_fil_data, $logg_tekst . "\n", FILE_APPEND);
}

//Tiden det ble logga
$logg_tid = date('Y-m-d H:i:s');
//Melding som logges
$logg_tekst = "Nytt medlem lagt til i systemet av bruker med id" . $_SESSION["user_id"];

loggfunksjon("Tidspunkt: . $logg_tid ");
loggfunksjon($logg_tekst);

//Finner log filen
$finn_logg = date_default_timezone_get();
