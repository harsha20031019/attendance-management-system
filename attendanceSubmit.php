<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['gencode'])) {
    unset($_COOKIE['Gencode']);
    $msg = rand(100000, 999999);
    if (isset($_POST['gencode'])) {
        // echo "<h2> is set</h2>";
        include './dbconnect.php';
        $currenttime = time();
        $sql123 = "INSERT INTO `otp` VALUES ($msg,$currenttime)";
        $result123 = mysqli_query($conn, $sql123);
        if ($result123 == true) {
            $genCode = true;
        }
        // class workerThread extends Thread
        // {
        //     public function run()
        //     {
        //         // while (true) {
        //         //     echo $this->i;
        //         //     sleep(1);
        //         // }
        //         sleep(30);
        //         include './dbconnect.php';
        //         $sql = " TRUNCATE `attendance1`.`otp`";
        //         $result = mysqli_query($conn, $sql);
        //     }
        // }

        // for ($i = 0; $i < 50; $i++) {
        //     $workers[$i] = new workerThread($i);
        //     $workers[$i]->start();
        // }

        // $start = new workerThread();
        // $start->start();

        // $sql = " TRUNCATE `attendance1`.`otp`";
        // $result = mysqli_query($conn, $sql);


        setcookie('Gencode', $msg, time() + 10);
        $_COOKIE['Gencode'] = $msg;
    } else {
        echo "not set";
    }
}
?>




<head>
    <script>
        window.history.forward();
    </script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FACHOME</title>
    <link rel="stylesheet" href="./css/aS.css" />
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="container">
            <div class="span">
                <span>Subject :
                    <?php
                    $fid = $_SESSION["f_id"];
                    $subcode = $_SESSION["SUBJECT"];
                    echo $_SESSION["SUBJECT"]; ?></span>
                <span>Semester :
                    <?php
                    $sem = $_SESSION["SEMESTER"];
                    echo $_SESSION["SEMESTER"]; ?></span>
                <span>Section :
                    <?php
                    $sec = $_SESSION["SECTION"];
                    echo $_SESSION["SECTION"]; ?></span>
            </div>
            <div class="gencode">
                <div>
                    <button id="quit" class="btn" type="submit" name="quit"> QUIT </button>
                    <?php
                    if (isset($_POST['quit'])) {
                        include './dbconnect.php';
                        $proc = 'proc_s_temp' . $_SESSION["SEMESTER"] . $_SESSION["SECTION"];
                        $sql4 = "CALL `$proc`();";
                        $result4 = mysqli_query($conn, $sql4);
                        $statusdeletesql = "DELETE FROM `status` WHERE `f_id`='$fid' AND `subject`='$subcode' AND `semester`='$sem' AND `section`='$sec'";
                        $resultDelStatus = mysqli_query($conn, $statusdeletesql);
                        if ($result4 && $resultDelStatus) {
                            unset($_SESSION["SUBJECT"]);
                            unset($_SESSION['Date']);
                            unset($_SESSION['SEMESTER']);
                            unset($_SESSION['SECTION']);
                            header("location: faculty.php");
                        }
                    }
                    ?>
                    <button id="gencode" class="btn" type="submit" onclick="" name="gencode">GENERATE
                        CODE</button>
                    <!-- <script>
                    function startTimer() {
                        <?php
                        // include './dbconnect.php';
                        // $currenttime = time();
                        // // $msg123 = rand(100000, 999999);
                        // $sql123 = "INSERT INTO `otp` VALUES ($msg,$currenttime)";
                        // $result123 = mysqli_query($conn, $sql123);
                        ?>
                        document.getElementById("msg").innerHTML = "jkhbkjasdfkj";

                        // const myTimeout = setTimeout(delOTP, 10000);
                    }

                    function delOTP() {
                        document.getElementById("msg").innerHTML = document.getElementById("msg").innerHTML +
                            " executed";
                        clearTimeout(myTimeout);
                        <?php
                        // include './dbconnect.php';
                        // $sql456 = " TRUNCATE `attendance1`.`otp`";
                        // $result456 = mysqli_query($conn, $sql456);
                        ?>

                    }
                    </script> -->
                    <button id="refresh" class="btn" type="submit" name="refresh">REFRESH</button>
                </div>
                <P id="msg">
                    <?php
                    global $msg;
                    if ($genCode = true && $msg != null) {

                        echo  $msg;
                    } else {
                        echo "Please generate CODE";
                    }
                    ?>
                </P>
            </div>
            <div class="table">
                <table id="login_students">
                    <tr>
                        <th>USN</th>
                        <th width=0%>login_student Name</th>
                        <th colspan="2">A/P</th>
                    </tr>
                    <?php
                    if (isset($_POST['refresh'])) {
                        include './dbconnect.php';
                        $tablename = 'S_temp' . $_SESSION["SEMESTER"] . $_SESSION["SECTION"];
                        $sql = " SELECT * FROM `$tablename`;";
                        $result = mysqli_query($conn, $sql);
                        $num = mysqli_num_rows($result);
                        while ($x = mysqli_fetch_array($result)) {
                    ?>
                            <tr>
                                <td><?php echo $x['usn']; ?></td>
                                <td><?php echo $x['SName']; ?></td>
                                <?php
                                if ($x['AorP'] == 1) {
                                    $check = "checked";
                                } else {
                                    $check = "unchecked";
                                }

                                ?>
                                <td> <?php echo $x['AorP']; ?></td>
                                <td><a href="changeAorP.php?usn=<?php echo $x['usn']; ?>">change</a></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
            <div>
                <button formaction="finalSubmit.php" formmethod="POST" name="submit" class="btn">Submit
                    Attendance</button>
            </div>
        </div>
    </form>
</body>

</html>