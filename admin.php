<?php
$result2 = '';
$match = true;
// $count = 0;
$exists = false;
session_start();
// echo $_COOKIE['Gencode'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include './dbconnect.php';
    $userid = $_SESSION['usn'];
    $username = $_SESSION['s_name'];

    try {
        $sql1 = " SELECT * FROM `s_temp` WHERE `USN`='$userid';";
        $result1 = mysqli_query($conn, $sql1);
        $num1 = mysqli_num_rows($result1);
    } catch (Exception $ex) {
        echo "Error in Database";
    }

    if ($num1 == 0) {
        if (isset($_POST["SUBMIT_ATTENDANCE"])) {
            if ($_COOKIE['Gencode'] == $_POST["code"]) {

                $sql2 = " INSERT INTO `s_temp` (`USN`, `SName`, `AorP`) VALUES ('$userid', '$username', '1');";
                $result2 = mysqli_query($conn, $sql2);
                // $count = 1;
            } elseif ($_COOKIE['Gencode'] != $_POST["code"]) {
                $match = false;
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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin</title>
    <link rel="stylesheet" href="./css/admin.css" />
</head>

<body>
    <header class="header">
        <nav>
            <ul>
                <li>
                    <a id="nav" href="admin.php">HOME</a>
                    <a id="nav" href="signcpw.php">CHANGE PASSWORD</a>
                    <a id="nav" href="login.php">LOGOUT</a>

                </li>
            </ul>
        </nav>

    </header>
    <div class="sidebar">
        <div class="user">
            <div style="margin: auto;font-size: 22px;">Logged in as</div>
            <span><?php echo $_SESSION['admin_name']; ?></span>
        </div>
        <a href="add_faculty.php">Add Faculty</a>
        <a href="add_student.php">Add student</a>
        <a href="view_faculty.php">show faculty details</a>
        <a href="query.php">query database</a>
    </div>


</body>

</html>