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
$userid = $_SESSION['f_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include './dbconnect.php';
    // $userid = $_POST["userid"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    if ($password == " ") {
        $v = true;
        // echo "enter an valid value";
    }

    if ($password != $cpassword) {
        $p = true;
    } else {
        $e = true;
    }

    if (isset($_POST["update"]) && $v == false && $e == true) {
        $sql = "UPDATE `login_faculty` SET `password`='$password' WHERE `f_id`='$userid'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $r = true;

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
    <link rel="stylesheet" href="./css/signcpwfac.css" />
</head>

<body>
    <header class="header">
        <nav>
            <ul>
                <li>
                    <a href="faculty.php">HOME</a>
                    <a href="signcpwfac.php">CHANGE PASSWORD</a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>Change password</h2>
        <div>
            <p><?php if ($r) {
                    echo 'Password updated succesfully..!';
                } ?></p>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <table>
                <tr><td>USER</td><td><input type="text" name="userid" maxlength="10" value="<?php echo $userid; ?>" readonly></td></tr>
                <tr><td>NEW PASSWORD</td><td><input type="password" name="password" id="myInput1" placeholder="enter password" required></td></tr>
                <tr><td>CONFIRM PASSWORD</td><td><input type="password" name="cpassword" id="myInput2" placeholder="confirm password" required></td></tr>
                <tr><td colspan="2"><input type="checkbox" class="checkbox" onclick="myFunction()"> Show Password</td></tr>
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
                <tr><td colspan="2"><button type="submit" class="btn" name='update'>UPDATE</button></td></tr>
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