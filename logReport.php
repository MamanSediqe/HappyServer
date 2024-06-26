<?php
require_once "Links.php";

$today = date('Y-m-d');

$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : $today;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : $today;
$maxRecords = isset($_GET['max_records']) ? min($_GET['max_records'], 300) : 100; 

$endDatePlusOne = date('Y-m-d', strtotime($endDate . ' +1 day'));

$myDB = new LinksDB();
$conn = $myDB->conn;

$sql = "SELECT * FROM UsersLog";
if ($startDate && $endDate) {
    $sql .= " WHERE LogTime BETWEEN '$startDate' AND '$endDatePlusOne'";
}
$sql .= " ORDER BY LogTime DESC LIMIT $maxRecords;";

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
        #filterForm {
            position: sticky;
            top: 0;
            background: white;
            padding: 10px;
            border-bottom: 1px solid #dddddd;
        }
    </style>
</head>
<body>

<div id="filterForm">
    <form method="GET" action="">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>" required>
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($endDate); ?>" required>
        <label for="max_records">Max Records (Limit to 200):</label>
        <input type="number" id="max_records" name="max_records" value="<?php echo htmlspecialchars($maxRecords); ?>" min="1" max="200">
        <button type="submit">Show</button>
        <a href="logSumReport.php?start_date=<?php echo htmlspecialchars($startDate); ?>&end_date=<?php echo htmlspecialchars($endDate); ?>" style="margin-left: 10px;">
            Show Device Count
        </a>
    </form>
</div>

<h2>User Logs</h2>

<table>
    <tr>
        <th>Log ID</th>
        <th>Log Time</th>
        <th>User IP</th>
        <th>Device ID</th>
        <th>App Version</th>
        <th>Referrer</th>
        <th>Location</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["LogId"] . "</td>";
            echo "<td>" . $row["LogTime"] . "</td>";
            echo "<td>" . $row["UserIP"] . "</td>";
            echo "<td>" . $row["DeviceId"] . "</td>";
            echo "<td>" . $row["AppVersion"] . "</td>";
            echo "<td>" . $row["RefUrl"] . "</td>";
            echo "<td>" . $row["Location"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No logs found</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php

$myDB->Disconnect();

?>
