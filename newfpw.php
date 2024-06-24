<?php
$u = '';
$p = false;
$r = false;
$e = false;
$v = false;
$emailsent = false;
$cookie = false;
$valU = '';
$valE = '';
$num = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    session_start();
    include './dbconnect.php';
    $userid = $_POST["userid"];
    $_SESSION["userid"] = $_POST["userid"];
    $email = $_POST["email"];
    $otp = $_POST["otp"];
    // session_start();
    // $_SESSION['username'] = $_POST["userid"];;
    // SELECT * FROM `login_faculty` WHERE `f_id`='$userid' UNION
    $sql = "SELECT * FROM `login_student` WHERE `usn`='$userid'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if ($userid == "" or $email == "") {
        $e = true;
        // echo "enter an valid value";
    }

    if ($num == 1 && $e == false) {
        $u = true;
    }

    $msg = rand(100000, 999999);

    if (isset($_POST['genotp']) && $u) {
        // send email
        mail($email, "OTP for Forgotpassword", $msg, "sendemailattendance@gmail.com");
        setcookie("otp", $msg);
        $_COOKIE['otp'] = $msg;

        // echo $_COOKIE['otp'];
        // echo "      ";
        // echo $msg;
        $emailsent = true;
        $valU = trim($_POST['userid']);
        $valE = trim($_POST['email']);
    }

    if (isset($_POST['submit'])) {
        $valU = trim($_POST['userid']);
        $valE = trim($_POST['email']);
        if ($otp == $_COOKIE['otp']) {
            // echo $_COOKIE['otp'];
            header("location: newcpw.php");
        } elseif ($otp != $_COOKIE['otp'] && $v = true) {
            $p = true;
            // echo "invalid otp";
        }

        unset($_POST['submit']);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password</title>
    <link rel="stylesheet" href="./css/signup.css" />
</head>

<body>
    <div class="full-page">
        <div id='login-form' class='login-page'>
            <div class="form-box">
                <div><img class="signinimg" src="./css/1.png" alt="img" /></div>
                <button type='button' class='toggle-btn'>Forgot Password..!</button>
                <form id='register' class='input-group-register' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <?php
                    if ($e) {
                        echo '    <p id="p" >
                        Enter valid deatils
                        </p>';
                    }
                    if ($num == 0) {
                        echo '    <p id="p" >
                        User id not found
                        </p>';
                        $num == '';
                    } elseif ($emailsent) {

                        echo '    <p id="p" style="color:#60fd60;">
                        OTP Sent
                        </p>';
                    }
                    if ($p) {
                        echo '    <p id="p">
                        Invalid OTP
                        </p>';
                    }
                    ?>
                    <!-- <input type='text' name="name" class='input-field' placeholder='Enter Name' value='<?php echo $valN; ?>' required> -->
                    <input type='text' name="userid" class='input-field' maxlength="15" placeholder='USN / FID ' value='<?php echo $valU; ?>' required>
                    <input type='email' name="email" class='input-field' placeholder='Email Id' value='<?php echo $valE; ?>' required>
                    <input type="submit" class='submit-btn' id="otp" name="genotp" value="GENERATE OTP" />
                    <input type='password' name="otp" class='input-field' id="input1" maxlength="6" placeholder='Enter OTP'>
                    <!-- <input type='password' name="cpassword" class='input-field' id="input2" maxlength="8" placeholder='Confirm Password' required> -->
                    <div class="lastrow"><input type='checkbox' class='check-box' onclick="myFunction()"><span>Show</span></div>
                    <button class='submit-btn' type="submit" name="submit">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function myFunction() {
            var x = document.getElementById("input1");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>