<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include './dbconnect.php';
    $sem = $_SESSION["SEMESTER"];
    $sec = $_SESSION["SECTION"];
    $subcode = $_SESSION["SUBJECT"];
    $fid = $_SESSION['f_id'];
    $tablename = "$sem$sec";
    echo $tablename;
    $tablename2 = 'S_temp' . $_SESSION["SEMESTER"] . $_SESSION["SECTION"];
    $proc = 'proc_s_temp' . $_SESSION["SEMESTER"] . $_SESSION["SECTION"];

    switch ($_SESSION["SUBJECT"]) {
        case "21CSPC501":
            $sql1 = " UPDATE `$tablename` SET Total1 = Total1+1 ";
            break;
        case "21CCPC502":
            $sql1 = " UPDATE `$tablename` SET Total2 = Total2+1 ";
            break;
        case "21CCPC503":
            $sql1 = " UPDATE `$tablename` SET Total3 = Total3+1 ";
            break;
        case "21CIPC504":
            $sql1 = " UPDATE `$tablename` SET Total4 = Total4+1 ";
            break;
        case "21CIPC505L":
            $sql1 = " UPDATE `$tablename` SET Total5 = Total5+1 ";
            break;
        case "21CCPC506L":
            $sql1 = " UPDATE `$tablename` SET Total6 = Total6+1 ";
            break;
        case "21CIAE507L":
            $sql1 = " UPDATE `$tablename` SET Total7 = Total7+1 ";
            break;
        case "21CVHS508":
            $sql1 = " UPDATE `$tablename` SET Total8 = Total8+1 ";
            break;
        default:
            echo "Error: Unknown";
    }

    $result1 = mysqli_query($conn, $sql1);

    $sql2 = " SELECT * FROM `$tablename2` WHERE `AorP` = 1 ";
    $result2 = mysqli_query($conn, $sql2);
    $num = mysqli_num_rows($result2);
    if ($result1) {
        while ($x = mysqli_fetch_array($result2)) {
            $sql3 = " UPDATE `$tablename` SET $subcode = $subcode + 1 WHERE `usn` = '$x[usn]'";
            $result3 = mysqli_query($conn, $sql3);
        }
        $sql4 = "CALL `$proc`();";
        $result4 = mysqli_query($conn, $sql4);
        $_SESSION["AttendanceUpdated"] = true;

        // $statusdeletesql = "DELETE FROM `status` WHERE `fid`='$fid' `subject`='$subcode' `semester`='$sem' `section`='$sec'";
        $statusdeletesql = "DELETE FROM `status` WHERE `f_id`='$fid' AND `subject`='$subcode' AND `semester`='$sem' AND `section`='$sec'";
        $resultDelStatus = mysqli_query($conn, $statusdeletesql);

        header("location: faculty.php");
    }
}

unset($_SESSION["SUBJECT"]);
unset($_SESSION['Date']);
unset($_SESSION['SEMESTER']);
unset($_SESSION['SECTION']);
