<?php
$result2 = '';
$match = true;
$cookieexist = true;
// $count = 0;
$exists = false;
session_start();
// echo $_COOKIE['Gencode'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include './dbconnect.php';
    $userid = $_SESSION['usn'];
    $username = $_SESSION['s_name'];
    // $statusSem = $_POST["sem"];
    // $statusSec = $_POST["sec"];
    $tablename = 's_temp' . $_POST["sem"] . $_POST["sec"];

    try {
        $sql1 = " SELECT * FROM `$tablename` WHERE `USN`='$userid';";
        $result1 = mysqli_query($conn, $sql1);
        $num1 = mysqli_num_rows($result1);
        $x = mysqli_fetch_array($result1);
    } catch (Exception $ex) {
        echo "Error in Database";
    }

    if ($x['AorP'] == 0) {
        if (isset($_POST["SUBMIT_ATTENDANCE"])) {
            // if (isset($_COOKIE['Gencode']) && $_COOKIE['Gencode'] == $_POST["code"]) {
            $sql222 = " SELECT `otp` FROM `otp` ";
            $sql333 = " SELECT `currentTime` FROM `otp` ";
            $result222 = mysqli_query($conn, $sql222);
            $result333 = mysqli_query($conn, $sql333);
            $i = 0;
            while ($temp = mysqli_fetch_array($result222)) {
                $otpArray[$i] = $temp['otp'];
                // echo $otpArray[$i] . "\n";
                // echo "<br>";
                $i++;
            }
            $i = 0;
            while ($temp1 = mysqli_fetch_array($result333)) {
                $currentTimeArray[$i] = $temp1['currentTime'];
                // echo $currentTimeArray[$i];
                // echo "<br>";
                $i++;
            }
            // echo $otpArray[count($otpArray) - 1];
            $checkOTP = $otpArray[count($otpArray) - 1];
            // echo "<br>";
            // echo $currentTimeArray[count($currentTimeArray) - 1];
            $checkCTIME = $currentTimeArray[count($currentTimeArray) - 1];

            $num222 = mysqli_num_rows($result222);
            $currenttimeThis = time();
            // if (isset($_COOKIE['Gencode']) && $_COOKIE['Gencode'] == $_POST["code"] && $checkOTP == $_POST["code"]) {
            if ($num222 != 0 && isset($_POST["code"])) {
                // echo "111111111111111111111111111111111111";
                // echo $num222;
                if ($checkOTP == $_POST["code"] && ($currenttimeThis - $checkCTIME) < 11) {
                    // echo "222222222222222222222222222222222222222";
                    $sql2 = " UPDATE `$tablename` SET `AorP`='1' WHERE `USN`='$userid';";
                    $result2 = mysqli_query($conn, $sql2);
                }
                if (!(($currenttimeThis - $checkCTIME) < 11)) {
                    // } elseif ($num222 = mysqli_num_rows($result222) < 1) {
                    // echo "3333333333333333333333333333333333333333333333";
                    $cookieexist = false;
                } else if ($checkOTP != $_POST["code"]) {
                    // } elseif ($checkOTP != $_POST["code"]) {
                    // echo "444444444444444444444444444444444444444444";
                    $match = false;
                }

                // $count = 1;
            } else if ($checkOTP != $_POST["code"]) {
                // } elseif ($checkOTP != $_POST["code"]) {
                // echo "444444444444444444444444444444444444444444";
                $match = false;
            }
            if (!(($currenttimeThis - $checkCTIME) < 11)) {
                // } elseif ($num222 = mysqli_num_rows($result222) < 1) {
                // echo "3333333333333333333333333333333333333333333333";
                $cookieexist = false;
            } else {
                // echo "Something Went Wrong..!";
            }
        }
    } else {
        $exists = true;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script>
    window.history.forward();
    </script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>login_student HOME</title>
    <link rel="stylesheet" href="./css/student.css" />
</head>

<body>
    <header class="header">

        <ul>
            <li>
                <a href="student.php">HOME</a>
                <a href="myattendance.php">MY ATTENDANCE</a>
                <a href="signcpw.php">CHANGE PASSWORD</a>
                <a href="logoutstudent.php">LOGOUT</a>
            </li>
        </ul>
        </nav>
        </div>

        <div id="pp">
            Logged in as <span><?php echo $_SESSION['s_name']; ?></span>
        </div>
    </header>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <table>
                <?php
                if (!$match) {
                    echo '    <p id="p" >
                            Wrong Code
                        </p>';
                }
                if (!$cookieexist) {
                    echo "    <p id='p' >
                            Sorry you're late..!
                        </p>";
                }
                if ($result2) {
                    echo '    <p id="p" style="color: green">
                            Attendance Updated Successfully..!
                        </p>';
                }
                if ($exists == true) {
                    echo '    <p id="p" >
                            You have already uploaded your attendance
                        </p>';
                }

                // include './dbconnect.php';
                // $statusSql = "SELECT `subject` FROM `status` WHERE `semester`= $statusSem AND `section` = '$statusSec' ;";
                // $statusResult = mysqli_query($conn, $statusSql);
                // if (!($numStatus = mysqli_num_rows($statusResult) > 1)) {
                //     // if (!isset($_SESSION["SUBJECT"])) {
                //     echo '    <p id="p" >
                //     No Faculty is taking Attendance
                // </p>';
                // }

                ?>
                <tr>
                    <td>REGISTER_NO</td>
                    <td>
                        <input name="USN" type="text" value="<?php echo $_SESSION['usn']; ?>" readonly>
                    </td>
                </tr>

                <!-- <tr>
                    <td>DATE</td>
                    <td>
                        <p><?php if (isset($_SESSION["Date"])) {
                                echo $_SESSION["Date"];
                            } else {
                                echo "NOT SET";
                            }
                            ?></p>
                    </td>
                </tr> -->
                <?php
                include './dbconnect.php';
                $userid = $_SESSION['usn'];
                $sql = " SELECT `sem`,`sec` FROM `login_student` s,`semsec` ss WHERE s.`ssid`= ss.`ssid` AND `usn`='$userid';";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                while ($x = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td>SEMESTER</td>
                    <td>
                        <input name="sem" type="text" value="<?php $statusSem = $x['sem'];
                                                                    echo $x['sem'];
                                                                    ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td>SECTION</td>
                    <td>
                        <input name="sec" type="text" value="<?php $statusSec = $x['sec'];
                                                                    echo $x['sec'];
                                                                    ?>" readonly>
                    </td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td>SUBJECT</td>
                    <?php
                    // if (isset($_SESSION["SUBJECT"])) { 
                    //         echo $_SESSION["SUBJECT"];
                    //     } else {
                    //         echo "// NOT SET //";
                    //     }
                    $notSet = null;
                    include './dbconnect.php';
                    $statusSql = "SELECT `subject` FROM `status` WHERE `semester`= $statusSem AND `section` = '$statusSec' ;";
                    $statusResult = mysqli_query($conn, $statusSql);
                    if ($numStatus = mysqli_num_rows($statusResult) == 1) {
                        $notSet = "null";
                        while ($stsub = mysqli_fetch_array($statusResult)) {
                    ?>

                    <td> <input name="subject" type="text" value="<?php echo $stsub['subject']; ?>" readonly>
                    </td>

                    <?php
                        }
                    } else {
                        ?>
                    <td style="color: green;"> NOT SET
                    </td>
                    <?php
                    }
                    ?>
                </tr>
                <?php
                include './dbconnect.php';
                $statusSql = "SELECT `subject` FROM `status` WHERE `semester`= $statusSem AND `section` = '$statusSec' ;";
                $statusResult = mysqli_query($conn, $statusSql);
                $noFacTakeAttend = null;
                if ($numStatus = mysqli_num_rows($statusResult) == 0) {
                    // if (!isset($_SESSION["SUBJECT"])) {
                    $noFacTakeAttend = true;
                    echo '    <p id="p" >
                                    No Faculty is taking Attendance
                                </p>';
                }

                ?>
                <tr>
                    <td>Enter Code</td>
                    <td>
                        <input name="code" type="text" required <?php if ($noFacTakeAttend == true) {
                                                                    echo "disabled";
                                                                } ?>>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit" class="btn" id="b" name="SUBMIT_ATTENDANCE">SUBMIT ATTENDANCE</button>
                    </td>
                </tr>

            </table>
        </form>
    </div>

</body>

</html>