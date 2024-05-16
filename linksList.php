<?php

require_once "Links.php";

$myDB = new LinksDB();
$conn = $myDB->conn;

$url = 'https://ukfarsi.com/vpn/list.php';

// Use file_get_contents to fetch the content
$content = file_get_contents($url);

if ($content === FALSE) {
    // Handle the error if the URL couldn't be fetched
    die('Error fetching the URL.');
}

// Split the content into lines
$lines = explode("\n", $content);

// Create an array to store the modified lines
$modifiedLines = [];

// Process each line
foreach ($lines as $line) {
    // Trim whitespace from the beginning and end of the line
    $line = trim($line);

    // Check if the line starts with 'VLESS' or 'VMESS'
    if (strpos($line, 'vless') === 0 || strpos($line, 'vmess') === 0) {
        // Modify the line as needed
        // For example, you can convert the line to uppercase
     
        // Add the modified line to the array
        $modifiedLines[] = $line;
        echo $line.'\n';
    }
}


// Step 1: Detect IP address
$userIP = $_SERVER['REMOTE_ADDR'];

// Step 2: Extract relevant information from the URL
$url = $_SERVER['REQUEST_URI'];
$parts = parse_url($url);
parse_str($parts['query'], $query);
$appVersion = $query['V'];
$deviceId = $query['id'];
$refUrl = $_SERVER['HTTP_REFERER']; // Referrer URL

$logTime = date('Y-m-d H:i:s');
$userIP = $_SERVER['REMOTE_ADDR'];
$deviceId =  $query['id'];
$appVersion =  $query['V'];
$refUrl = $_SERVER['REQUEST_URI'];


$strSQL = "INSERT INTO `UsersLog` ( `LogTime`, `UserIP`, `DeviceId`, `AppVersion`, `RefUrl`) VALUES 
( '$logTime', '$userIP', '$deviceId', '$appVersion', '$refUrl')";
$myDB = new LinksDB();
$myDB->Connect();

if ($myDB->conn->query($strSQL) === true) {
    $myDB->Disconnect();
    return true;
}
else {
    $this->ErrorMessage = $myDB->conn->error . "<br>";
    $myDB->Disconnect();
    return false;
}

?>
