<?php
session_start();
include './dbconnect.php';
$userid = $_SESSION['usn'];
$sql1 = " SELECT * FROM `login_student` WHERE `USN`='$userid';";
$result1 = mysqli_query($conn, $sql1);
$x1 = mysqli_fetch_array($result1);
$tablename = "$x1[ssid]";
$sql2 = " SELECT * FROM `$tablename` WHERE `USN`='$userid';";
$result2 = mysqli_query($conn, $sql2);
$x2 = mysqli_fetch_array($result2);
$sql3 = " SELECT `subject_name` FROM `subject`;";
$result3 = mysqli_query($conn, $sql3);
$x3 = mysqli_fetch_array($result3);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>login_student HOME</title>
    <link rel="stylesheet" href="./css/myAttendance.css" />
</head>

<body>
    <header class="header">
        <nav>
            <ul>
                <li>
                    <a href="student.php">HOME</a>
                    <a href="myattendance.php">MY ATTENDANCE</a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="totpercentage">
        Overall Attendance : <?php echo $x2['Totalpercentage'] . "%"; ?>
    </div>
    <div id="piechart"></div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        // Load google charts
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        // Draw the chart and set the chart values

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Subject', 'Attendance'],
                ['PSP  <?php echo (int)$x2['percentage1'] . "%"; ?>', <?php echo $x2['percentage1'] ?>],
                ['CN <?php echo (int)$x2['percentage2'] . "%"; ?>', <?php echo $x2['percentage2'] ?>],
                ['DBMS <?php echo (int)$x2['percentage3'] . "%"; ?>', <?php echo $x2['percentage3'] ?>],
                ['AUTOMATA <?php echo (int)$x2['percentage4'] . "%"; ?>', <?php echo $x2['percentage4'] ?>],
                ['CN LAB <?php echo (int)$x2['percentage5'] . "%"; ?>', <?php echo $x2['percentage5'] ?>],
                ['DBMS LAB <?php echo (int)$x2['percentage6'] . "%"; ?>', <?php echo $x2['percentage6'] ?>],
                ['PYTHON LAB <?php echo (int)$x2['percentage7'] . "%"; ?>', <?php echo $x2['percentage7'] ?>],
                ['EVS <?php echo (int)$x2['percentage8'] . "%"; ?>', <?php echo $x2['percentage8'] ?>]

            ]);


            // Optional; add a title and set the width and height of the chart
            // var options = { tooltip: { trigger: 'selection' }};
            var options = {
                'title': '',
                // titleTextStyle :{ color: <string>,fontName: <string>,fontSize: <number>,bold: <boolean>,italic: <boolean> },
                'width': 400,
                'height': 500,
                pieHole: 0.3,
                pieSliceText: 'label',
                pieSliceTextStyle: {
                    color: 'white',
                    fontName: 'cursive',
                    fontSize: 12
                },
                backgroundColor: 'none',
                chartArea: {
                    left: '%',
                    top: '8%',
                    width: 500,
                    height: 700,
                    alignment: 'center'

                },
                legend: {
                    position: 'none',
                    textStyle: {
                        color: 'blue',
                        fontSize: 16
                    },
                    alignment: 'center'
                },
                tooltip: {
                    trigger: 'label'
                }
            };

            // Display the chart inside the <div> element with id="piechart"
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    </script>
</body>

</html>