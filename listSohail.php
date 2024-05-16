<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Tehran');
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
$websitePath = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
global $All_vmosses_Array;
$All_vmosses_Array=[];
$ReportedApp = "";
$DeviceID = "";
if (isset($_REQUEST["V"])){
    $ReportedApp = $_REQUEST['V'];
}
if (isset($_REQUEST["id"])){
    $DeviceID = $_REQUEST['id'];
}

// Include database class
require_once 'database.php';

// Create a new instance of the database class
$DB = new Data_Base();

// Retrieve configurations from the database
$ConfigsDB = $DB->Get_All_Configs();

// Check if configurations were retrieved successfully
if ($ConfigsDB && $ConfigsDB->num_rows > 0) {
    // Fetch all configurations as associative array
    $ConfigsList = $ConfigsDB->fetch_all(MYSQLI_ASSOC);

    // Sort configurations by the SortOrder property
    usort($ConfigsList, function($a, $b) {
        // Convert SortOrder values to integers before comparison
        return intval($a["SortOrder"]) - intval($b["SortOrder"]);
    });

    // Echo each element's Content in one line
    foreach ($ConfigsList as $element) {
        if (substr($element["Content"], 0, 8) !== 'vmoss://' && substr($element["Content"], 0, 8) !== 'vmuss://') {
            echo $element["Content"] . "\n";
        }elseif(substr($element["Content"], 0, 8) === 'vmoss://' || substr($element["Content"], 0, 8) === 'vmuss://') {
              array_push($All_vmosses_Array, $element["Content"]);
          }
    }
} else {
    // No configurations found
    echo "No configurations found.";
}

function deEncriptor($str) {
    $result = "";

    if (substr($str, 0, 8) === "vmoss://" || substr($str, 0, 8) === "vmuss://") {
        $str = substr($str, 8);
        for ($i = 0; $i < strlen($str); $i += 3) {
            $result .= $str[2];
            $str = substr($str, 3);
            if (substr($str, 0, 2) === "99") {
                break;
            }
        }
    }

    return $result;
}
$must_show_vmosses=[];
/*
for ($i = 0; $i < count($All_vmosses_Array); $i++) {
    if(strpos($websitePath, deEncriptor($All_vmosses_Array[$i]))){
        array_push($must_show_vmosses, $All_vmosses_Array[$i]);
        if ($i+1<=count($All_vmosses_Array)) {
            array_push($must_show_vmosses, $All_vmosses_Array[$i+1]);
        }
    }
}
*/
foreach ($All_vmosses_Array as $element) {
    echo $element . "\n";
}

function getClientIP() {
    // Check if the X-Forwarded-For header exists
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
        // Split the header and return the first IP address (original client IP)
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ips[0]);
    }

    // If X-Forwarded-For header doesn't exist, return the remote address
    return $_SERVER['REMOTE_ADDR'];
}

// Function to get client location using IP geolocation service
function getClientLocation($ip) {
    // Create the URL for the ip-api.com service
    $url = "http://ip-api.com/json/{$ip}";

    // Make a request to the ip-api.com service
    $data = file_get_contents($url);

    // Decode the JSON response
    $location = json_decode($data);

    // Return the location information
    return $location;
}

// Get client IP address
$client_ip = getClientIP();

// Echo the client IP address
//echo "Client IP Address: " . $client_ip . "<br>";

// Get client location
$client_location = getClientLocation($client_ip);

// Echo the client location information
//echo "Client Location: " . $client_location->city . ", " . $client_location->regionName . ", " . $client_location->country . "<br>";

// Function to get device model using PHP
function getDeviceModel() {
    // Get the user agent
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    // Check if the user agent contains common device identifiers
    if (strpos($user_agent, 'iPhone') !== false) {
        return 'iPhone';
    } elseif (strpos($user_agent, 'iPad') !== false) {
        return 'iPad';
    } elseif (strpos($user_agent, 'Android') !== false) {
        return 'Android';
    } elseif (strpos($user_agent, 'Windows Phone') !== false) {
        return 'Windows Phone';
    } elseif (strpos($user_agent, 'Macintosh') !== false) {
        return 'Macintosh';
    } elseif (strpos($user_agent, 'Windows') !== false) {
        return 'Windows';
    } elseif (strpos($user_agent, 'Linux') !== false) {
        return 'Linux';
    } else {
        return 'Unknown';
    }
}

// Get device model
$device_model = getDeviceModel();

// Echo the device model
//echo "Device Model1: " . $device_model;
//$DB->Create_Logs_Table();

//$client_ip=$client_location=$device_model="mamad";
$client_Address  = $client_location->city . ", " . $client_location->regionName . ", " . $client_location->country;
$websitePath = $_SERVER['HTTP_HOST'];
$DB->Insert_Log($client_ip,$client_Address,$device_model,$websitePath,$ReportedApp,$DeviceID,date('Y-m-d H:i:s'));
?>
