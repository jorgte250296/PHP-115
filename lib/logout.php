
<?php
//Starter sesjon
session_start();

//Avslutter sesjonen
session_destroy();

//redirect til logg inn
header("location: logginn.php");
exit;
?>