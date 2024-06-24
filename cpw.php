<?php

$u = false;
$p = false;
$r = false;
$e = false;
$v = false;
$uid = '';
$password = '';
$cpassword = '';

session_start();
$uid = $_SESSION["userid"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include './dbconnect.php';
    $userid = $_POST["userid"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    $sql1 = "SELECT * FROM `login_faculty` WHERE `f_id`='$userid'";
    $sql2 = "SELECT * FROM `login_login_student` WHERE `usn`='$userid'";

    $result1 = mysqli_query($conn, $sql1);
    $result2 = mysqli_query($conn, $sql2);

    $num1 = mysqli_num_rows($result1);
    $num2 = mysqli_num_rows($result2);

    if ($password == "") {
        $v = true;
        // echo "enter an valid value";
    }

    if ($password != $cpassword) {
        $p = true;
    } else {
        $e = true;
    }

    if ($num1 == 1) {
        $sql = "UPDATE `login_faculty` SET `password`='$password' WHERE `f_id`='$userid'";
    } elseif ($num2 == 1) {
        $sql = "UPDATE `login_login_student` SET `password`='$password' WHERE `usn`='$userid'";
    }

    $result = mysqli_query($conn, $sql);

    if ($p == false && $v == false) {
        if ($result) {
            $r = true;
            $_SESSION["pasupdated"] = 'Password updated succesfully';
            header("location: login.php");
            // echo "registered succesfully";
        } else {

            echo "something went wrong";
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
    <title>CHGPSW</title>
    <link rel="stylesheet" href="./css/fpw.css" />
</head>

<body>
    <div class="container">
        <img class="signinimg" src="./css/1.png" alt="img" />
        <h2>Change password</h2>
        <div>

        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <table>
                <tr>
                    <td>USER</td>
                    <td>
                        <input type="text" name="userid" maxlength="10" value="<?php echo $uid; ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td>NEW PASSWORD</td>
                    <td>
                        <input type="password" name="password" id="myInput1" placeholder="enter password">
                    </td>
                </tr>

                <tr>
                    <td>CONFIRM PASSWORD</td>
                    <td>
                        <input type="password" name="cpassword" id="myInput2" placeholder="confirm password">
                    </td>

                </tr>
                <tr>
                    <td colspan="2">
                        <div class="lastrow"> <input type="checkbox" class="checkbox" onclick="myFunction()"> Show Password</div>
                    </td>

                </tr>

                <?php
                if ($v) {
                    print "
                        <tr>
                        <td  colspan='2'>
                        <span  style='color:red'>Enter valid password </span> 
                        </td>
                        </tr>
                    ";
                }
                if ($p) {
                    print "
                        <tr>
                        <td  colspan='2'>
                        <span  style='color:red'>Password does not match </span> 
                        </td>
                        </tr>
                    ";
                }
                ?>

                <tr>
                    <td colspan="2">
                        <button type="submit" class="btn" name='update'>UPDATE</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <script>
        function myFunction() {
            var x = document.getElementById("myInput1");
            var y = document.getElementById("myInput2");
            if (x.type === "password" && y.type === "password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }
    </script>
</body>

</html>