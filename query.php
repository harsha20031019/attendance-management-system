<?php
include './dbconnect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = $_POST["query"];

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo "<div class='error'>Error in query: " . htmlspecialchars($conn->error) . "</div>";
    } else {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // echo "<table>";
                // echo "<thead><tr>";
                // // Get field names
                // $fields = $result->fetch_fields();
                // foreach ($fields as $field) {
                //     echo "<th>" . htmlspecialchars($field->name) . "</th>";
                // }
                // echo "</tr></thead><tbody>";
                // // Get rows
                // while ($row = $result->fetch_assoc()) {
                //     echo "<tr>";
                //     foreach ($row as $cell) {
                //         echo "<td>" . htmlspecialchars($cell) . "</td>";
                //     }
                //     echo "</tr>";
                // }
                // echo "</tbody></table>";
            } else {
                echo "<div class='no-results'>0 results</div>";
            }
        } else {
            echo "<div class='error'>Error executing query: " . htmlspecialchars($stmt->error) . "</div>";
        }
    }
    $stmt->close();
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>SQL Query Executor</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
            align-items: center;

        }

        input[type="text"] {
            width: 500px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        .no-results {
            color: #555;
            font-weight: bold;
        }
    </style>
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
    <h1>ENTER YOUR QUERY BELOW</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Query:
        <input type="text" name="query">
        <input type="submit" value="Execute">

    </form>
    <?php
    $query = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $query = $_POST["query"];

        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            echo "<div class='error'>Error in query: " . htmlspecialchars($conn->error) . "</div>";
        } else {
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<thead><tr>";
                    // Get field names
                    $fields = $result->fetch_fields();
                    foreach ($fields as $field) {
                        echo "<th>" . htmlspecialchars($field->name) . "</th>";
                    }
                    echo "</tr></thead><tbody>";
                    // Get rows
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($row as $cell) {
                            echo "<td>" . htmlspecialchars($cell) . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<div class='no-results'>0 results</div>";
                }
            } else {
                echo "<div class='error'>Error executing query: " . htmlspecialchars($stmt->error) . "</div>";
            }
        }
        $stmt->close();
    }

    $conn->close();
    ?>
</body>

</html>