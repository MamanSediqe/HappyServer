<?php


require_once "Links.php";

$myDB = new LinksDB();
$conn = $myDB->conn;

// Query to select all records from the UsersLog table
$sql = "SELECT * FROM UsersLog";

// Execute the query
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Logs</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>User Logs</h2>

<table>
    <tr>
        <th>Log ID</th>
        <th>Log Time</th>
        <th>User IP</th>
        <th>Device ID</th>
        <th>App Version</th>
        <th>Referrer URL</th>
    </tr>
    <?php
    // Check if there are any records
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["LogId"] . "</td>";
            echo "<td>" . $row["LogTime"] . "</td>";
            echo "<td>" . $row["UserIP"] . "</td>";
            echo "<td>" . $row["DeviceId"] . "</td>";
            echo "<td>" . $row["AppVersion"] . "</td>";
            echo "<td>" . $row["RefUrl"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No logs found</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php

// Disconnect from the database
$myDb->Disconnect();

?>
