<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Attendance</title>
    <link rel="stylesheet" href="./css/Vattendance.css" />
</head>

<body>
    <header class="header">
        <nav>
            <ul>
                <li>
                    <a href="faculty.php">HOME</a>
                    <a href="Vattendance.php">VIEW ATTENDANCE </a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div>
                <span>SUBJECT </span>
                <select id="select" name="SUBJECT" id="">
                    <?php
                    include './dbconnect.php';
                    $userid = $_SESSION['f_id'];
                    $sql = " SELECT h.`subject_code`,`subject_name` FROM `handles` h,`subject` s WHERE h.`subject_code`=s.`subject_code` AND `f_id`='$userid' GROUP BY h.`subject_code`;";
                    $result = mysqli_query($conn, $sql);
                    $num = mysqli_num_rows($result);
                    while ($x = mysqli_fetch_array($result)) {
                    ?>
                        <option id="option" value="<?php echo $x['subject_code']; ?>">
                            <?php echo $x['subject_code'];
                            echo '/' . $x['subject_name']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div>
                <span>SEMESTER </span>
                <select id="select" name="SEMESTER" id="">
                    <?php
                    include './dbconnect.php';
                    $userid = $_SESSION['f_id'];
                    $sql = " SELECT `sem`,`sec` FROM `handles` h,`semsec` s WHERE h.`ssid`= s.`ssid` AND `f_id`='$userid' GROUP BY `sem`;";
                    $result = mysqli_query($conn, $sql);
                    $num = mysqli_num_rows($result);
                    while ($x = mysqli_fetch_array($result)) {
                    ?>
                        <option id="option" value="<?php echo $x['sem']; ?>"><?php echo $x['sem']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div>
                <span>SECTION </span>
                <select id="select" name="SECTION">
                    <?php
                    include './dbconnect.php';
                    $userid = $_SESSION['f_id'];
                    $sql = " SELECT `sem`,`sec` FROM `handles` h,`semsec` s WHERE h.`ssid`=s.`ssid` AND `f_id`='$userid' GROUP BY `sec` ;";
                    $result = mysqli_query($conn, $sql);
                    $num = mysqli_num_rows($result);
                    while ($x = mysqli_fetch_array($result)) {
                    ?>
                        <option id="option" value="<?php echo $x['sec']; ?>"><?php echo $x['sec']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div>
                <button type="submit" class="btn" id="b" name="VIEW_ATTENDANCE">View Attendance</button>
            </div>
        </form>
        <div class="table">
            <table id="login_students">
                <tr>
                    <th>USN</th>
                    <th>login_student Name</th>
                    <th>Percentage</th>
                </tr>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    include './dbconnect.php';
                    $subcode = $_POST["SUBJECT"];
                    $sem = $_POST["SEMESTER"];
                    $sec = $_POST["SECTION"];
                    $tablename = "$sem$sec";



                    switch ($subcode) {
                        case "21CSPC501":
                            $total = "percentage1";
                            break;
                        case "21CCPC502":
                            $total = "percentage2";
                            break;
                        case "21CCPC503":
                            $total = "percentage3";
                            break;
                        case "21CIPC504":
                            $total = "percentage4";
                            break;
                        case "21CIPC505L":
                            $total = "percentage5";
                            break;
                        case "21CCPC506L":
                            $total = "percentage6";
                            break;
                        case "21CIAE507L":
                            $total = "percentage7";
                            break;
                        case "21CVHS508":
                            $total = "percentage8";
                            break;
                    }
                    try {

                        $sql = " SELECT `t`.`USN`,`s_name`,`$total` FROM `$tablename` `t`,`login_student` `l` WHERE `t`.`USN`=`l`.`USN`;";
                        $result = mysqli_query($conn, $sql);
                    } catch (Exception $e) {
                        echo "NO RECORDS FOUND";
                    }
                    while ($x = mysqli_fetch_array($result)) {
                ?>
                        <tr>
                            <td><?php echo $x[0]; ?></td>
                            <td><?php echo $x[1]; ?></td>
                            <td><?php echo $x[2]; ?></td>

                        </tr>
                <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>

</body>

</html>