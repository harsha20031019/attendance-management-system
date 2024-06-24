<?PHP
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include './dbconnect.php';
    $usn = $_POST["usn"];
    $sname = $_POST["s_name"];
    $password = $_POST["password"];
    $ssid = $_POST["semsec"];
    mysqli_query($conn, "SET foreign_key_checks = 0;");
    $sql1 = "INSERT INTO `login_student` (`usn`, `s_name`, `password`,`ssid`) VALUES ('$usn','$sname','$password','$ssid');";
    $result1 = mysqli_query($conn, $sql1);
    mysqli_query($conn, "SET foreign_key_checks = 1;");
    if ($result1 == true) {
        echo "<p id='p'>student added successfully</p>";
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
    <title>ADD_FACULTY</title>
    <link rel="stylesheet" href="./css/login.css" />
</head>

<body>
    <div class="full-page">
        <div id='login-form' class='login-page'>
            <div class="form-box">
                <div><img class="signinimg" src="./css/1.png" alt="img" /></div>
                <button type='button' class='toggle-btn'>ADD FACULTY</button>
                <form id='login' class='input-group-login' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <input type='text' name="usn" class='input-field' maxlength="15" placeholder='Enter usn of student' required>
                    <input type='text' name="s_name" class='input-field' maxlength="15" placeholder='Enter name of student' required>
                    <input type='password' name="password" class='input-field' maxlength="15" placeholder='Enter student password' required>
                    <div class="lastrow"><input type='checkbox' class='check-box' onclick="myFunction()"><span>Show
                            Password</span></div>
                    <div id="ssid">
                        <select id="semsecid" name="semsec">
                            <option id="option" value="select">select</option>
                            <option id="option" value="5a">5a</option>
                            <option id="option" value="5b">5b</option>
                        </select>

                    </div>


                    <button type='submit' class='submit-btn'>ADD STUDENT</button>
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