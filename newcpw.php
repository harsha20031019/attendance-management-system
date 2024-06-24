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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Change Password</title>
    <link rel="stylesheet" href="./css/signup.css" />
</head>

<body>
    <div class="full-page">
        <div id='login-form' class='login-page'>
            <div class="form-box">
            <div><img class="signinimg" src="./css/1.png" alt="img" /></div>
                <button type='button' class='toggle-btn'>Change Password</button>
                <form id='register' class='input-group-register' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <?php
                    if ($v) {
                        echo '    <p id="p" >
                        Enter valid password
                        </p>';
                    }
                    if ($p) {
                        echo '    <p id="p" >
                        Password does not match
                        </p>';
                    }
                    ?>
                    <input type='text' name="userid" class='input-field' maxlength="10" value='<?php echo  $uid; ?>' readonly>
                    <input type='password' name="password" class='input-field' id="input1" maxlength="8" placeholder='Enter Password' required>
                    <input type='password' name="cpassword" class='input-field' id="input2" maxlength="8" placeholder='Confirm Password' required>
                    <div class="lastrow"><input type='checkbox' class='check-box' onclick="myFunction()"><span>Show Password</span></div>
                    <button type="submit" class='submit-btn' name='update'>UPDATE</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function myFunction() {
            var x = document.getElementById("input1");
            var y = document.getElementById("input2");
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