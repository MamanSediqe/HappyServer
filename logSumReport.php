<?php
require_once "Links.php";

// Get today's date in the format 'Y-m-d'
$today = date('Y-m-d');

// Check if start and end dates are set, otherwise default to today's date
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : $today;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : $today;

$endDatePlusOne = date('Y-m-d', strtotime($endDate . ' +1 day'));

$myDB = new LinksDB();
$conn = $myDB->conn;

// SQL query to fetch DeviceId counts and RefUrl based on date range if set
$deviceCountSql = "
    SELECT u.DeviceId, u.RefUrl, COUNT(u.DeviceId) AS DeviceCount
    FROM UsersLog u
    INNER JOIN (
        SELECT DeviceId
        FROM UsersLog
        WHERE LogTime BETWEEN '$startDate' AND '$endDatePlusOne'
        GROUP BY DeviceId
    ) AS grouped ON u.DeviceId = grouped.DeviceId
    WHERE u.LogTime BETWEEN '$startDate' AND '$endDatePlusOne'
    GROUP BY u.DeviceId, u.RefUrl
    ORDER BY DeviceCount DESC";

$deviceCountResult = $conn->query($deviceCountSql);

// Calculate total unique devices
$totalUniqueDevices = $deviceCountResult->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device Count</title>
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
        <button type="submit">Show</button>
    </form>
</div>

<h2>Device Count</h2>
<p>Total Unique Devices: <?php echo $totalUniqueDevices; ?></p>

<table>
    <tr>
        <th>#</th>
        <th>Device ID</th>
        <th>Referrer URL</th>
        <th>Count</th>
    </tr>
    <?php
    if ($deviceCountResult->num_rows > 0) {
        $rowNumber = 1;
        while($row = $deviceCountResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $rowNumber++ . "</td>";
            echo "<td>" . $row["DeviceId"] . "</td>";
            echo "<td>" . $row["RefUrl"] . "</td>";
            echo "<td>" . $row["DeviceCount"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No devices found</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php
$myDB->Disconnect();
?>
