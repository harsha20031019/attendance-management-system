<?php
$invalid = '';
$e = false;
$v = false;
$valU = '';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include './dbconnect.php';
    $userid = $_POST["userid"];
    $password = $_POST["password"];
    $valU = trim($_POST['userid']);

    if ($userid == "" or $password == "") {
        $v = true;
        // echo "enter an valid value";
    } else {
        $e = true;
    }

    $sql1 = " SELECT * FROM `login_student` WHERE `usn` = '$userid' AND `password`='$password';";
    $sql2 = " SELECT * FROM `login_faculty` WHERE `f_id` = '$userid' AND `password`='$password';";
    $sql3 = " SELECT * FROM `admin` WHERE `admin_id` = '$userid' AND `password`='$password';";


    $result1 = mysqli_query($conn, $sql1);
    $num1 = mysqli_num_rows($result1);
    $x1 = mysqli_fetch_array($result1);

    $result2 = mysqli_query($conn, $sql2);
    $num2 = mysqli_num_rows($result2);
    $x2 = mysqli_fetch_array($result2);

    $result3 = mysqli_query($conn, $sql3);
    $num3 = mysqli_num_rows($result3);
    $x3 = mysqli_fetch_array($result3);

    if ($num1 == 1 && $e == true) {
        $u = true;
        $_SESSION['usn'] = $x1["usn"];
        $_SESSION['s_name'] = $x1["s_name"];
        header("location: student.php");
    } elseif ($num2 == 1 && $e == true) {
        $u = true;
        $_SESSION['f_id'] = $x2["f_id"];
        $_SESSION['f_name'] = $x2["f_name"];
        header("location: faculty.php");
    } elseif ($num3 == 1 && $e == true) {
        $u = true;
        $_SESSION[`admin_id`] = $x3[`admin_id`];
        $_SESSION['admin_name'] = $x3["admin_name"];
        header("location: admin.php");
    } else {
        $invalid = true;
        // $showError = "Invalid Credentials";
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
    <title>LOGINPAGE</title>
    <link rel="stylesheet" href="./css/login.css" />
</head>

<body>
    <div class="full-page">
        <div id='login-form' class='login-page'>
            <div class="form-box">
                <div><img class="signinimg" src="./css/1.png" alt="img" /></div>
                <button type='button' class='toggle-btn'>Log In</button>
                <form id='login' class='input-group-login' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <input type='text' name="userid" class='input-field' maxlength="15" autocomplete="" placeholder='REGISTER_NO/ FID/ADMIN_ID' value='<?php echo $valU; ?>' required>
                    <input type='password' name="password" class='input-field' id="input" maxlength="8" placeholder='Enter Password' required>
                    <div class="lastrow"><input type='checkbox' class='check-box' onclick="myFunction()"><span>Show
                            Password</span><a href="newfpw.php" target="_blank"> Forgot Password? </a></div>
                    <?php
                    if (isset($_SESSION["pasupdated"])) {
                        echo '    <p id="p" style="color: green; font-weight: bold;" >
                                ' . $_SESSION["pasupdated"] . '
                        </p>';
                        unset($_SESSION["pasupdated"]);
                    }
                    if (isset($_SESSION["register"])) {
                        echo '    <p id="p" style="color: green; font-weight: bold;" >
                                ' . $_SESSION["register"] . '
                        </p>';
                        unset($_SESSION["register"]);
                    }
                    if ($v) {
                        echo '    <p id="p" >
                                Enter valid deatils
                        </p>';
                    } elseif ($invalid) {
                        echo '    <p id="p">
                                Invalid Credentials
                        </p>';
                    }
                    ?>
                    <button type='submit' class='submit-btn'>Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function myFunction() {
            var x1 = document.getElementById("input");
            if (x1.type === "password") {
                x1.type = "text";
            } else {
                x1.type = "password";
            }
        }
    </script>
</body>


</html>