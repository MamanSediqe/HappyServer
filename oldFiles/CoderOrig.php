<?php

function generateString($main_str) {
    $prefix = "vmoss://" . getRandomChar() . getRandomChar();  // Prefix with two random characters
    $suffix = "99";  // Suffix
    $result = $prefix;

    // Add main string with two random characters between each character
    for ($i = 0; $i < strlen($main_str)-1; $i++) {
        $result .= $main_str[$i] . getRandomChar() . getRandomChar();
    }
    $result .= substr($main_str, -1);

    // Add suffix
    $result .= $suffix;

    // If the length is less than 150, add more random characters
    while (strlen($result) < 150) {
        $result .= getRandomChar();
    }

    return substr($result, 0, 150);  // Truncate to 150 characters
}

function getRandomChar() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    return $characters[rand(0, strlen($characters) - 1)];
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the main string from the form
    $main_str = $_POST["main_str"];

    // Generate the final string
    $final_str = generateString($main_str);
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
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="main_str">Enter Main String:</label><br>
        <input type="text" id="main_str" name="main_str"><br><br>
        <input type="submit" value="Generate String">
    </form>

    <?php if (isset($final_str)): ?>
        <h4 onclick="copyToClipboard(this.innerText)"><?php echo $final_str; ?></h4>
    <?php endif; ?>
</body>

</html>
<script type="text/javascript">
function copyToClipboard(text) {
    navigator.clipboard.writeText(text)
        .then(() => {
            console.log('Text copied to clipboard successfully');
        })
        .catch(err => {
            console.error('Unable to copy text to clipboard: ', err);
        });
}
</script>
