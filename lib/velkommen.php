<?php
//Starter sesjonen og sjekker at brukeren er logget inn før data kan bli aksesert
require_once "../inc/validering.php";

?>
<?php require_once "..\inc\header.php"; ?>
<section>
    <h1>Velkommen</h1>
    <h2 class="my-5">Hei bruker nr: <b><?php echo htmlspecialchars($_SESSION["user_id"]); ?></b>. Velkommen til NEO ungdomsklubb.</h2>
</section>
<?php require_once "../inc/footer.php" ?>