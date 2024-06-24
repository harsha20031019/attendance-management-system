<?PHP
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include './dbconnect.php';
    $FID = $_POST["f_id"];
    $FNAME = $_POST["f_name"];
    $PASSWORD = $_POST["password"];
    $sql1 = " INSERT INTO `login_faculty` (`f_id`, `f_name`, `password`) VALUES ('$FID','$FNAME','$PASSWORD')";
    $result1 = mysqli_query($conn, $sql1);
    if ($result1 == true) {
        echo "<p id='p'>faculty added successfully</p>";
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
                    <input type='text' name="f_id" class='input-field' maxlength="15" placeholder='Enter faculty ID' required>
                    <input type='text' name="f_name" class='input-field' maxlength="15" placeholder='Enter faculty name' required>
                    <input type='password' name="password" class='input-field' maxlength="15" placeholder='Enter faculty password' required>
                    <div class="lastrow"><input type='checkbox' class='check-box' onclick="myFunction()"><span>Show
                            Password</span></div>



                    <button type='submit' class='submit-btn'>ADD FACULTY</button>
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