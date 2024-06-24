<?php
    unset($_SESSION['f_id']);
    unset($_SESSION['f_name']);
    unset($_SESSION["SUBJECT"]);
    unset($_SESSION['Date']);
    unset($_SESSION['SEMESTER']);
    unset($_SESSION['SECTION']);
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();
    header("location: login.php");

?>
