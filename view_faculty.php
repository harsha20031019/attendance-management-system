<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Attendance</title>
    <link rel="stylesheet" href="./css/Vattendance.css" />
</head>

<body>
    <header class="header">
        <nav>
            <ul>
                <li>
                    <a href="admin.php">HOME</a>


                </li>
            </ul>
        </nav>
    </header>


    <div>

    </div>
    <div>
    </div>
    <form type="post">
        <div class="table">
            <table id="login_students">
                <tr>
                    <th>FACULTY NAME</th>
                    <th>SSID</th>
                    <th>SUBJECT</th>
                </tr>
                <?php


                include './dbconnect.php';





                try {

                    $sql = " Select f_name,h.ssid, subject_name from login_faculty l, handles h,subject s where l.f_id=h.f_id and h.subject_code=s.subject_code Group by f_name;";
                    $result = mysqli_query($conn, $sql);
                } catch (Exception $e) {
                    echo "NO RECORDS FOUND";
                }
                while ($x = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $x[0]; ?></td>
                        <td><?php echo $x[1]; ?></td>
                        <td><?php echo $x[2]; ?></td>

                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
        </div>
    </form>

</body>

</html>