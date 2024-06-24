<?php
$ex;
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include './dbconnect.php';

    $statusFID = $_SESSION['f_id'];
    $statusSUBJECT = $_POST["SUBJECT"];
    $statusSEMESTER = $_POST["SEMESTER"];
    $statusSECTION = $_POST["SECTION"];
    $statusSql = "INSERT INTO `status`(`f_id`,`subject`,`semester`,`section`) VALUES ('$statusFID','$statusSUBJECT','$statusSEMESTER','$statusSECTION');";

    $statusResult = mysqli_query($conn, $statusSql);
    $_SESSION["SUBJECT"] = $_POST["SUBJECT"];
    $_SESSION["Date"] = $_POST["Date"];
    $_SESSION["SEMESTER"] = $_POST["SEMESTER"];
    $_SESSION["SECTION"] = $_POST["SECTION"];


    $proc = 'proc_s_temp' . $_SESSION["SEMESTER"] . $_SESSION["SECTION"];
    if (isset($_POST["TAKE_ATTENDANCE"])) {
        $sql = "CALL `$proc`();";
        try {
            $result = mysqli_query($conn, $sql);
            if ($result) {
                header("location: attendanceSubmit.php");
            } else {
                echo 'Something went wrong';
            }
        } catch (Exception $ex) {
            echo "Error in Database" . $ex;
        }
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
    <title>FACHOME</title>
    <link rel="stylesheet" href="./css/faculty.css" />
</head>

<body>
    <header class="header">
        <nav>
            <ul>
                <li>
                    <a href="faculty.php">HOME</a>
                    <a href="Vattendance.php">VIEW ATTENDANCE </a>
                    <a href="signcpwfac.php">CHANGE PASSWORD</a>
                    <a href="logoutfac.php">LOGOUT</a>
                </li>
            </ul>
        </nav>
        <div id="pp">
            Logged in as <span><?php echo $_SESSION['f_name']; ?></span>
        </div>
    </header>
    <?php
    if (isset($_SESSION["AttendanceUpdated"]) && $_SESSION["AttendanceUpdated"] == true) {
        echo '    <p id="p" style="color: green">
                            Attendance Updated Successfully..!
                        </p>';
        unset($_SESSION["AttendanceUpdated"]);
    }
    ?>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div>
                <p>ATTENDANCE</p>
            </div>
            <table>
                <tr>
                    <td>SUBJECT</td>
                    <td>
                        <select id="select" name="SUBJECT" id="">
                            <?php
                            include './dbconnect.php';
                            $userid = $_SESSION['f_id'];
                            $sql = " SELECT h.`subject_code`,`subject_name` FROM `handles` h,`subject` s WHERE h.`subject_code`= s.`subject_code` AND `f_id`= '$userid'GROUP BY h.`subject_code`;";
                            $result = mysqli_query($conn, $sql);
                            $num = mysqli_num_rows($result);
                            while ($x = mysqli_fetch_array($result)) {
                            ?>
                                <option id="option" value="<?php echo $x['subject_code']; ?>">
                                    <?php echo $x['subject_code'];
                                    echo '/' . $x['subject_name']; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>DATE</td>
                    <td>
                        <input type="text" name="Date" id="date" value='' readonly>
                        <script>
                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1;
                            var yyyy = today.getFullYear();
                            console.log(today.getDate());
                            console.log(today.getMonth() + 1);
                            console.log(today.getFullYear());
                            if (dd < 10) {
                                dd = "0" + dd;
                            }
                            if (mm < 10) {
                                mm = "0" + mm;
                            }
                            document.getElementById("date").value = dd + ' - ' + mm + ' - ' + yyyy;
                        </script>
                    </td>
                </tr>
                <tr>
                    <td>SEMESTER</td>
                    <td>
                        <select id="select" name="SEMESTER" id="">
                            <?php
                            include './dbconnect.php';
                            $userid = $_SESSION['f_id'];
                            $sql = " SELECT `sem`,`sec` FROM `handles` h,`semsec` s WHERE h.`ssid`=s.`ssid` AND `f_id`='$userid' GROUP BY `sem`;";
                            $result = mysqli_query($conn, $sql);
                            $num = mysqli_num_rows($result);
                            while ($x = mysqli_fetch_array($result)) {
                            ?>
                                <option id="option" value="<?php echo $x['sem']; ?>"><?php echo $x['sem']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>SECTION</td>
                    <td>
                        <select id="select" name="SECTION">
                            <?php
                            include './dbconnect.php';
                            $userid = $_SESSION['f_id'];
                            $sql = " SELECT `sem`,`sec` FROM `handles` h,`semsec` s WHERE h.`ssid`=s.`ssid` AND `f_id`='$userid' GROUP BY `sec`;;";
                            $result = mysqli_query($conn, $sql);
                            $num = mysqli_num_rows($result);
                            while ($x = mysqli_fetch_array($result)) {
                            ?>
                                <option id="option" value="<?php echo $x['sec']; ?>"><?php echo $x['sec']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit" class="btn" id="b" name="TAKE_ATTENDANCE">Take Attendance</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

</body>

</html>