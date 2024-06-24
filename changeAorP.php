<?php
session_start();
$usn = $_GET['usn'];

include './dbconnect.php';
$tablename = 'S_temp'.$_SESSION["SEMESTER"].$_SESSION["SECTION"];
$sql = " SELECT * FROM `$tablename` WHERE `USN`='$usn';";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
$x = mysqli_fetch_array($result);
if ($x['AorP'] == 1) {
    $sql1 = " UPDATE `$tablename` SET `AorP`= 0 WHERE `USN`='$usn';";
    $result1 = mysqli_query($conn, $sql1);
    header("location: attendanceSubmit.php");
} elseif ($x['AorP'] == 0) {
    $sql2 = " UPDATE `$tablename` SET `AorP`= 1 WHERE `USN`='$usn';";
    $result2 = mysqli_query($conn, $sql2);
    header("location: attendanceSubmit.php");
}

?>