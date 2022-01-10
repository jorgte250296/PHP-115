<?php
//Starter session og sjekker tilkobling til database opp mot "user_id"
session_start();

if(!isset($_SESSION['user_id'])){

   echo "Vennligst logg inn først";
   echo "<script>setTimeout(\"location.href = 'logginn.php';\",1500);</script>";
   exit;
}
