<?php
require_once "Links.php";
$combined_Parameters = "ABCDEF";
$currentLink = new Link(0);
$combined_URLs = "";
readParameters();
function encodeParameter($main_str, $suffix)
{
    $charCount = 2;
    $prefix = getRandomChar($charCount);  // Prefix with two random characters
    // Suffix
    $result = $prefix;
    // echo $prefix . $suffix . "<br>";
    // Add main string with two random characters between each character
    for ($i = 0; $i < strlen($main_str) - 1; $i++) {
        $result .= $main_str[$i] . getRandomChar($charCount);
        //echo  $result. "<br>";
    }
    $result .= substr($main_str, -1);

    // Add suffix
    $result .= $suffix;
    return ($result);
}

function getRandomChar($count)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz012345678';
    $output = "";
    for ($i = 0; $i < $count; $i++)
        $output .= $characters[rand(0, strlen($characters) - 1)];
    return $output;
}

function decodeString($generatedString, $suffix)
{
    $generatedString = substr($generatedString, 7);
    $decodedValues = explode($suffix, $generatedString);
    foreach ($decodedValues as &$value) {
        $meaningfulParts = "";
        for ($j = 3; $j < strlen($value); $j += 3) {
            $meaningfulParts .= $value[$j];
        }
        $value = $meaningfulParts;
    }
    array_pop($decodedValues);
    return $decodedValues;
}

function decodeURL($generatedString, $suffix)
{
    $generatedString = substr($generatedString, 7);
    $decodedValues = substr($generatedString, 0, strpos($generatedString, $suffix));
    $meaningfulPart = "";
    for ($j = 3; $j < strlen($decodedValues[0]); $j += 3) {
        $meaningfulPart .= $decodedValues[0][$j];
    }

    return $meaningfulPart;
}

// Usage example:
/*$generatedString = $_POST["generatedString"]; // Assuming it's coming from a form post
$decodedValues = decodeString($generatedString);
list($lateset_ver, $max_secs, $max_delay, $adv_address, $min_refmins, $max_refmins, $netping_url, $vpnping_url) = $decodedValues;
// Now you can use these variables as needed
*/
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['encodeParameters'])) {
        // Get the main string from the form
        encodeParameters();
    }
    if (isset($_POST['readParameters'])) {
        // Get the main string from the form
        readParameters();
    }
    if (isset($_POST['saveParameters'])) {
        // Get the main string from the form
        saveParameters();
    }
}

function readParameters()
{
    global $ref_url, $res_url2, $res_url3, $res_url4, $res_url, $currentLink, $combined_Parameters, $lateset_ver, $max_secs, $max_delay, $adv_address, $min_refmins, $max_refmins, $netping_url, $vpnping_url, $measureby_ping,$notif_id,$notif_msg,$getad_waitsecs, $getad_retrycnt;
    $currentLink = new Link(0);
    $currentLink->fetchByTitle("Server 97");
    $combined_Parameters =  $currentLink->LinkValue;
    $decodedValues = decodeString($currentLink->LinkValue, "#9a");
    list($lateset_ver, $max_secs, $max_delay, $adv_address, $min_refmins, $max_refmins, $netping_url, $vpnping_url, $measureby_ping,$notif_id,$notif_msg,$getad_waitsecs, $getad_retrycnt) = $decodedValues;

    $currentLink->fetchByTitle("Server 98");
    $decodedValues = decodeString($currentLink->LinkValue, "#90");
    list($res_url, $res_url2, $res_url3, $res_url4) = $decodedValues;
    $currentLink->fetchByTitle("Server 99");
    $decodedValues = decodeString($currentLink->LinkValue, "#90");
    list($ref_url) = $decodedValues;
}

function saveParameters()
{
    global $combined_URLs, $ref_url, $res_url, $currentLink, $combined_Parameters;
    encodeParameters();
    $currentLink->fetchByTitle("Server 97");
    //  $combined_Parameters =  $currentLink->LinkValue;
    $currentLink->LinkValue = $combined_Parameters;
    $currentLink->Update();

    $currentLink->fetchByTitle("Server 98");
    /*  $encoded_ref = "vmoss://";
    $encoded_ref .= encodeParameter($ref_url, '#901');       
    while (strlen( $encoded_ref) < 250) {
        $encoded_ref .= getRandomChar(1);
    } */
    $currentLink->LinkValue =  $combined_URLs;
    $currentLink->Update();

    $currentLink->fetchByTitle("Server 99");
    $encoded_ref = "vmoss://";
    $encoded_ref .= encodeParameter($ref_url, '#901');
    while (strlen($encoded_ref) < 250) {
        $encoded_ref .= getRandomChar(1);
    }
    $currentLink->LinkValue =  $encoded_ref;
    $currentLink->Update();
    readParameters();
}

function encodeParameters()
{
    global $combined_URLs, $ref_url, $res_url2, $res_url3, $res_url4, $res_url, $combined_Parameters, $lateset_ver, $max_secs, $max_delay, $adv_address, $min_refmins, $max_refmins, $netping_url, $measureby_ping,$notif_id,$notif_msg,$getad_waitsecs, $getad_retrycnt;
    $lateset_ver = $_POST["lateset_ver"];
    $max_secs = $_POST["max_secs"];
    $max_delay = $_POST["max_delay"];
    $min_refmins = $_POST["min_refmins"];
    $adv_address = $_POST["adv_address"];
    $max_refmins = $_POST["max_refmins"];
    $netping_url = $_POST["netping_url"];
    $vpnping_url = $_POST["vpnping_url"];
    $measureby_ping = $_POST['measureby_ping'] === 'on' ? 'True': 'False';
    $notif_id = $_POST["notif_id"];
    $notif_msg = $_POST["notif_msg"];
    $getad_waitsecs = $_POST["getad_waitsecs"];
    $getad_retrycnt = $_POST["getad_retrycnt"];
    //$measureby_ping = $_POST["measureby_ping"];
    $ref_url = $_POST["ref_url"];
    $res_url2 = $_POST["res_url2"];
    $res_url3 = $_POST["res_url3"];
    $res_url4 = $_POST["res_url4"];
    $res_url = $_POST["res_url"];
    $combined_Parameters = "vmuss://";
    $combined_Parameters .= encodeParameter($lateset_ver, '#9a1');
    $combined_Parameters .= encodeParameter($max_secs, '#9a2');
    $combined_Parameters .= encodeParameter($max_delay, '#9a3');
    $combined_Parameters .= encodeParameter($adv_address, '#9a4');
    $combined_Parameters .= encodeParameter($min_refmins, '#9a5');
    $combined_Parameters .= encodeParameter($max_refmins, '#9a6');
    $combined_Parameters .= encodeParameter($netping_url, '#9a7');
    $combined_Parameters .= encodeParameter($vpnping_url, '#9a8');
    $combined_Parameters .= encodeParameter($measureby_ping, '#9a9');
    $combined_Parameters .= encodeParameter($notif_id, '#9aa');
    $combined_Parameters .= encodeParameter($notif_msg, '#9ab');
    $combined_Parameters .= encodeParameter($getad_waitsecs , '#9ac');
    $combined_Parameters .= encodeParameter($getad_retrycnt, '#9ad');
    while (strlen($combined_Parameters) < 512) {
        $combined_Parameters .= getRandomChar(1);
    }
    $combined_Parameters = substr($combined_Parameters, 0, 1024);
    //echo "combined_Parameters:" . $combined_Parameters;

    $combined_URLs = "vmoss://";
    $combined_URLs .= encodeParameter($res_url, '#902');
    if (strlen($res_url2) > 4) {
        $combined_URLs .= encodeParameter($res_url2, '#903');
    }
    if (strlen($res_url3) > 4) {
        $combined_URLs .= encodeParameter($res_url3, '#904');
    }
    if (strlen($res_url4) > 4) {
        $combined_URLs .= encodeParameter($res_url4, '#905');
    }
    while (strlen($combined_URLs) < 300) {
        $combined_URLs .= getRandomChar(1);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Parameters</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #666;
            font-size: large;
            color: #333;
            margin: 0;
            text-align: center;
        }

        form {
            background-color: #555;
            padding: 10px;
            border-radius: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        h2 {
            color: #fee;
            margin-top: 10px;
        }

        label {
            font-weight: bold;
            font-size: medium;
            margin-top: 10px;
            display: inline-block;
            width: 85%;
            text-align: left;
        }

        input[type="text"],
        input[type="checkbox"],
        textarea {
            width: calc(85%);
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            display: inline-block;
            vertical-align: top;
            font-size: large;
        }

        input[type="submit"],
        button {
            background-color: #551111;
            color: #eee;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
            display: inline-block;
            vertical-align: top;

            cursor: pointer;
            width: calc(45%);
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .oddDiv {
            padding: 10px;
            background-color: #111111;
            color: #eee;
            min-height: 45px;
            border-radius: 10px;
            border: 2px solid #eee;
            margin-bottom: 5px;
        }

        .evenDiv {
            padding: 10px;
            background-color: #404040;
            color: #eee;
            min-height: 45px;
            border-radius: 10px;
            border: 2px solid #eee;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <form method="post" action="">
        <input type="submit" name='readParameters' value="Read Parameters">
        <input type="submit" name='saveParameters' value="Save Parameters">
        <h2>Current Parameters</h2>
        <div class="oddDiv">
            <label for="notif_id">Notification ID:</label>
            <input type="text" id="notif_id" name="notif_id" value="<?php echo isset($notif_id) ? $notif_id: ''; ?>">
        </div>
        <div class="evenDiv">
            <label for="notif_msg">Notification Message:</label>
            <input type="text" id="notif_msg" name="notif_msg" value="<?php echo isset($notif_msg) ? $notif_msg: ''; ?>">
        </div>
        <div class="oddDiv">
            <label for="lateset_ver">Latest Version:</label>
            <input type="text" id="lateset_ver" name="lateset_ver" value="<?php echo isset($lateset_ver) ? $lateset_ver: ''; ?>">
        </div>
        <div class="evenDiv">
            <label for="max_secs">Maximum permitted connection seconds:</label>
            <input type="text" id="max_secs" name="max_secs" value="<?php echo isset($max_secs) ? $max_secs: ''; ?>">
        </div>
        <div class="oddDiv">
            <label for="max_delay">Max acceptable delay:</label>
            <input type="text" id="max_delay" name="max_delay" value="<?php echo isset($max_delay) ? $max_delay: ''; ?>">
        </div>
        <div class="evenDiv">
            <label for="adv_address">Advertize link address:</label>
            <input type="text" id="adv_address" name="adv_address" value="<?php echo isset($adv_address) ? $adv_address: ''; ?>">
        </div>
        <div class="oddDiv">
            <label for="min_refmins">Min minutes refresh servers:</label>
            <input type="text" id="min_refmins" name="min_refmins" value="<?php echo isset($min_refmins) ? $min_refmins: ''; ?>">
        </div>
        <div class="evenDiv">
            <label for="combined_Parameters">Max minutes refresh servers:</label>
            <input type="text" id="max_refmins" name="max_refmins" value="<?php echo isset($max_refmins) ? $max_refmins: ''; ?>">
        </div>
        <div class="oddDiv">
            <label for="getad_waitsecs">Get Ad Wait Seconds:</label>
            <input type="text" id="getad_waitsecs" name="getad_waitsecs" value="<?php echo isset($getad_waitsecs) ? $getad_waitsecs: ''; ?>">
        </div>
        <div class="evenDiv">
            <label for="getad_retrycnt">Get Ad Retry Count:</label>
            <input type="text" id="getad_retrycnt" name="getad_retrycnt" value="<?php echo isset($getad_retrycnt) ? $getad_retrycnt: ''; ?>">
        </div>
        <div class="oddDiv">
            <label for="netping_url">Network ping URL (Domain name Only like google.com):</label>
            <input type="text" id="netping_url" name="netping_url" value="<?php echo isset($netping_url) ? $netping_url: ''; ?>">
        </div>
        <div class="evenDiv">
            <label for="vpnping_url">VPN ping URL (Domain name Only like facebook.com):</label>
            <input type="text" id="vpnping_url" name="vpnping_url" value="<?php echo isset($vpnping_url) ? $vpnping_url: ''; ?>">
        </div>
        <div class="oddDiv">
            <label for="vpnping_url">Measure Delay By Ping:</label>
            <input type="checkbox" id="measureby_ping" name="measureby_ping" <?php echo $measureby_ping === 'True' ? 'checked': ''; ?>>
        </div>
        <h2>Web urls list </h2>
        <div class="evenDiv">
            <label for="ref_url">Refrence URL:</label>
            <input type="text" id="ref_url" name="ref_url" value="<?php echo isset($ref_url) ? $ref_url: ''; ?>">
        </div>
        <div class="oddDiv">
            <label for="res_url">Reserve URL:</label>
            <input type="text" id="res_url" name="res_url" value="<?php echo isset($res_url) ? $res_url: ''; ?>">

        </div>
        <div class="evenDiv">
            <label for="res_url2">Ref2:</label>
            <input type="text" id="res_url2" name="res_url2" value="<?php echo isset($res_url2) ? $res_url2: ''; ?>">
        </div>
        <div class="oddDiv">
            <label for="res_url3">Ref3:</label>
            <input type="text" id="res_url3" name="res_url3" value="<?php echo isset($res_url3) ? $res_url3: ''; ?>">
        </div>
        <div class="evenDiv">
            <label for="res_url4">Ref4:</label>
            <input type="text" id="res_url4" name="res_url4" value="<?php echo isset($res_url4) ? $res_url4: ''; ?>">
        </div>
        <div class="oddDiv">
            <input type="submit" name='encodeParameters' value="Encode Parameters">
        </div>

    </form>
    <?php if (isset($combined_Parameters)): ?>

        <div class="evenDiv"> <textarea id="generatedString" rows="4" cols="50"><?php echo htmlspecialchars($combined_Parameters); ?></textarea><br>
            <button onclick="copyToClipboard()">Copy to Clipboard</button>
            <button onclick="decodeString()" id='decodeParameters'>Decode Psrameters</button>
        </div>
    <?php endif; ?>
    <script>
        function copyToClipboard() {
            // Select the text area
            var textarea = document.getElementById("generatedString");
            textarea.select();
            textarea.setSelectionRange(0, 99999); // For mobile devices

            // Copy the selected text to the clipboard
            document.execCommand("copy");
            console.log('Text copied to clipboard successfully');
            // Deselect the text area
            textarea.blur();
        }

        function decodeString() {
            var generatedString = document.getElementById("generatedString").value;
            generatedString = generatedString.substring(7);
            var decodedValues = generatedString.split("#9a");
            console.log('decodedValues' + decodedValues);
            for (var i = 0; i < decodedValues.length; i++) {
                var meaningfulParts = "";
                console.log('generatedString ' + i + " > " + decodedValues[i]);
                for (var j = 3; j < decodedValues[i].length; j += 3) {
                    meaningfulParts += decodedValues[i].charAt(j);
                }
                console.log('meaningfulParts[i]:' + meaningfulParts);
                decodedValues[i] = meaningfulParts;
            }
            document.getElementById("lateset_ver").value = decodedValues[0];
            document.getElementById("max_secs").value = decodedValues[1];
            document.getElementById("max_delay").value = decodedValues[2];
            document.getElementById("adv_address").value = decodedValues[3];
            document.getElementById("min_refmins").value = decodedValues[4];
            document.getElementById("max_refmins").value = decodedValues[5];
            document.getElementById("netping_url").value = decodedValues[6];
            document.getElementById("vpnping_url").value = decodedValues[7];
            document.getElementById("measureby_ping").checked = decodedValues[8];
            document.getElementById("notif_id").checked = decodedValues[9];
            document.getElementById("notif_msg").checked = decodedValues[10];
        }
    </script>
</body>

</html>