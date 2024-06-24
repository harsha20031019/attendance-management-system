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

    $sql = "SELECT * FROM `login_faculty` WHERE `f_id`='$userid'
            UNION
            SELECT * FROM `login_login_student` WHERE `usn`='$userid'";
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
        setcookie("otp",$msg);
        $_COOKIE['otp']=$msg;

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
            header("location: cpw.php");
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
    <title>FORGOT PASSWORD</title>
    <link rel="stylesheet" href="./css/fpw.css" />

</head>

<body>
    <div class="container">
        <h2>FORGOT PASSWORD..!!</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <table>
                <h4>FID for Faculty & USN for login_students</h4>

                <tr>
                    <td>ENTER USER ID:</td>
                    <td>
                        <input type="text" name="userid" placeholder="enter user id" value="<?php echo $valU; ?>" />
                    </td>
                </tr>

                <tr>
                    <td>ENTER E-MAIL ADDRESS:</td>
                    <td>
                        <input type="email" name="email" placeholder="enter your e-mail" value="<?php echo $valE; ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" id="otp" name="genotp" value="GENERATE OTP" />
                    </td>
                </tr>
                <tr>
                    <td>ENTER OTP:</td>
                    <td>
                        <input type="text" name="otp" placeholder="enter otp" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button class="btn" name="submit">SUBMIT</button>
                    </td>
                </tr>

                <?php
                if ($e) {
                    echo '    <p id="p" >
                            Enter valid deatils
                        </p>';
                }
                if ($num==0) {
                    echo '    <p id="p" >
                            User id not found
                        </p>';
                    $num=='';
                } 
                elseif ($emailsent) {

                    echo '    <p id="p" style="color:green;">
                            OTP Sent
                        </p>';
                }
                if ($p) {
                    echo '    <p id="p">
                            Invalid OTP
                        </p>';
                }
                ?>
            </table>
        </form>
    </div>

</body>

</html>