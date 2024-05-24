<?php

function generateString($main_str, $index)
{
    $charCount = 2;
    $prefix = getRandomChar($charCount);  // Prefix with two random characters
    $suffix = "#9a" . $index;  // Suffix
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['encodeParameters'])) {

        // Get the main string from the form
        $lateset_ver = $_POST["lateset_ver"];
        $max_secs = $_POST["max_secs"];
        $max_delay = $_POST["max_delay"];
        $min_refmins = $_POST["min_refmins"];
        $adv_address = $_POST["adv_address"];
        $max_refmins = $_POST["max_refmins"];
        $netping_url = $_POST["netping_url"];
        $vpnping_url = $_POST["vpnping_url"];
        $final_str = "vmuss://";
        $final_str .= generateString($lateset_ver, 1);
        $final_str .= generateString($max_secs, 2);
        $final_str .= generateString($max_delay, 3);
        $final_str .= generateString($adv_address, 4);
        $final_str .= generateString($min_refmins, 5);
        $final_str .= generateString($max_refmins, 6);
        $final_str .= generateString($netping_url, 7);
        $final_str .= generateString($vpnping_url, 8);
        while (strlen($final_str) < 250) {
            $final_str .= getRandomChar(1);
        }
        $truncated_final_str = substr($final_str, 0, 250);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generated String</title>
</head>

<body>
    <h2>Generate String</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="lateset_ver">Latest Version:</label><br>
        <input type="text" id="lateset_ver" name="lateset_ver" value="<?php echo isset($lateset_ver) ? $lateset_ver : ''; ?>"><br>
        <label for="max_secs">Connection Seconds Max:</label><br>
        <input type="text" id="max_secs" name="max_secs" value="<?php echo isset($max_secs) ? $max_secs : ''; ?>"><br>
        <label for="max_delay">Max acceptable delay:</label><br>
        <input type="text" id="max_delay" name="max_delay" value="<?php echo isset($max_delay) ? $max_delay : ''; ?>"><br>
        <label for="adv_address">Advertize link address:</label><br>
        <input type="text" id="adv_address" name="adv_address" value="<?php echo isset($adv_address) ? $adv_address : ''; ?>"><br>
        <label for="min_refmins">Min minutes refresh servers:</label><br>
        <input type="text" id="min_refmins" name="min_refmins" value="<?php echo isset($min_refmins) ? $min_refmins : ''; ?>"><br>
        <label for="final_str">Max minutes refresh servers:</label><br>
        <input type="text" id="max_refmins" name="max_refmins" value="<?php echo isset($max_refmins) ? $max_refmins : ''; ?>"><br>
       
        <label for="netping_url">Network ping URL:</label><br>
        <input type="text" id="netping_url" name="netping_url" value="<?php echo isset($netping_url) ? $netping_url : ''; ?>"><br>       
        <label for="vpnping_url">VPN ping URL:</label><br>
        <input type="text" id="vpnping_url" name="vpnping_url" value="<?php echo isset($vpnping_url) ? $vpnping_url : ''; ?>"><br>
              
        <label for="final_str">String to save:</label><br>
        <input type="text" id="final_str" name="final_str" value="<?php echo isset($final_str) ? $final_str : ''; ?>"><br>
    
        <input type="submit" name ='encodeParameters' value="Encode Parameters">
    </form>
    <?php if (isset($final_str)) : ?>
        <textarea id="generatedString" rows="4" cols="50"><?php echo htmlspecialchars($final_str); ?></textarea><br>
        <button onclick="copyToClipboard()">Copy to Clipboard</button>
        <button onclick="decodeString()" id='decodeParameters'>Decode Psrameters</button>
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
        }
    </script>
</body>

</html>