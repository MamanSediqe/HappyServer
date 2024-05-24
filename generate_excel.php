<?php
require_once "Links.php";
require 'vendor/autoload.php'; // Ensure you have autoload for PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$today = date('Y-m-d');

$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : $today;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : $today;
$endDatePlusOne = date('Y-m-d', strtotime($endDate . ' +1 day'));

$myDB = new LinksDB();
$conn = $myDB->conn;

// Fetch data from the database
$sql = "SELECT DeviceId, RefUrl, COUNT(*) AS DeviceCount FROM UsersLog";
if ($startDate && $endDate) {
    $sql .= " WHERE LogTime BETWEEN '$startDate' AND '$endDatePlusOne'";
}
$sql .= " GROUP BY DeviceId, RefUrl ORDER BY DeviceCount DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Create a new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add headers
    $sheet->setCellValue('A1', '#');
    $sheet->setCellValue('B1', 'Device ID');
    $sheet->setCellValue('C1', 'Referrer URL');
    $sheet->setCellValue('D1', 'Count');

    // Add data rows
    $rowNumber = 2;
    $index = 1;
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $index++);
        $sheet->setCellValue('B' . $rowNumber, $row['DeviceId']);
        $sheet->setCellValue('C' . $rowNumber, $row['RefUrl']);
        $sheet->setCellValue('D' . $rowNumber, $row['DeviceCount']);
        $rowNumber++;
    }

    // Set the HTTP headers for file download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="device_count.xlsx"');
    header('Cache-Control: max-age=0');

    // Write the spreadsheet to the output buffer
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    // Close the database connection
    $myDB->Disconnect();
    exit;
} else {
    echo "No data found for the selected date range.";
    $myDB->Disconnect();
}
?>
