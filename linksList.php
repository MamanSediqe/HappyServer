<?php

require_once "Links.php";

$myDB = new LinksDB();
$conn = $myDB->conn;
$getFromUKFarsi = false;
if ($getFromUKFarsi) {
    $url = 'https://ukfarsi.com/vpn/list.php';
    date_default_timezone_set('Asia/Tehran');
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
    $websitePath = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    // Use file_get_contents to fetch the content
    $content = file_get_contents($url);

    if ($content === FALSE) {
        die('Error fetching the URL.');
    }

    $lines = explode("\n", $content);
    $links = [];

    foreach ($lines as $line) {
        $line = trim($line);
        // Check if the line starts with 'VLESS' or 'VMESS'
        if (strpos($line, 'vless') === 0 || strpos($line, 'vmess') === 0) {
            $links[] = $line;
        }
    }
}
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT LinkValue FROM Links ORDER BY LinkTitle";
$result = $conn->query($sql);
//$LinkValues = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (strpos($row['LinkValue'], 'vmuss') === 0 || strpos($row['LinkValue'], 'vmoss') === 0 || !$getFromUKFarsi)
            //$LinkValues[] = $row['LinkValue'];
            $links[] = $row['LinkValue'];
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
$refUrl = $_SERVER['REQUEST_URI'].$_SERVER['REQUEST_URI'];
$refUrl=$_SERVER['HTTP_HOST'];

header('Content-Type: text/plain');
echo implode("\n", $links);
/*echo "\nIP: " . $userIP;
$client_location = getClientLocation($userIP);
echo "\nHost         " . $refUrl;

echo "\nLocation: " .  $client_location->regionName;
$client_Address  = $client_location->city . ", " . $client_location->regionName . ", " . $client_location->country. ", " . str_replace( ',','_', $client_location->isp);
echo "\nAddress: " . $client_Address;

$strSQL = "ALTER TABLE `UsersLog` ADD COLUMN `Location` varchar(1024)";
$myDB->conn->query($strSQL);
*/
$client_location = getClientLocation($userIP);
$client_Address  = $client_location->city . ", " . $client_location->regionName . ", " . $client_location->country. ", " . str_replace( ',','_', $client_location->isp);

$strSQL = "INSERT INTO `UsersLog` ( `LogTime`, `UserIP`, `DeviceId`, `AppVersion`, `RefUrl`, `Location`) VALUES 
( '$logTime', '$userIP', '$deviceId', '$appVersion', '$refUrl', '$client_Address')";

if ($myDB->conn->query($strSQL) === true) {
    $myDB->Disconnect();
    return true;
} else {
    $this->ErrorMessage = $myDB->conn->error . "<br>";
    $myDB->Disconnect();
    return false;
}


// Function to get client location using IP geolocation service
function getClientLocation($ip)
{
    // Create the URL for the ip-api.com service
    $url = "http://ip-api.com/json/{$ip}";

    // Make a request to the ip-api.com service
    $data = file_get_contents($url);

    // Decode the JSON response
    $location = json_decode($data);

    // Return the location information
    return $location;
}
