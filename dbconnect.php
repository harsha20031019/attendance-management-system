<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "attendance";

try {
    $conn = mysqli_connect($server, $username, $password, $database);
} catch (Exception $ex) {
    // $code = $ex->getCode();
    // $message = $ex->getMessage();
    // $file = $ex->getFile();
    // $line = $ex->getLine();
    // // echo "Exception thrown in $file on line $line: [Code $code]
    // // $message";
    echo '<h1>Failed to fetch DATA...</h1>';
}
