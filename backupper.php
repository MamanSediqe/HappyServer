<?php
require_once "Links.php";

// Basic authentication
$valid_passwords = array ("admin" => "12346");
$valid_users = array_keys($valid_passwords);

$user = @$_SERVER['PHP_AUTH_USER'];
$pass = @$_SERVER['PHP_AUTH_PW'];

$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

if (!$validated) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    die("Not authorized");
}

// Function to find the latest backup file
function find_latest_backup($dir) {
    $files = glob($dir . 'happy_db_backup_*.sql');
    if (!$files) {
        return false;
    }
    // Sort files by modification time, newest first
    usort($files, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });
    return $files[0];
}

// Handle the create backup request
if (isset($_POST['create_backup'])) {
    $myDB = new LinksDB();
    $conn = $myDB->conn;

    // Ensure we have the correct server name (localhost in this case)
    $servername = 'localhost';

    // Directory to save the backup file (using /tmp)
    $backupDir = '/tmp/';
    $backupFile = $backupDir . 'happy_db_backup_' . date('Y-m-d_H-i-s') . '.sql';

    // Command to backup database (fixed spaces in the command)
    $command = "mysqldump --user={$myDB->username} --password={$myDB->password} --host=$servername {$myDB->dbName} > $backupFile";

    // Execute the command and check for success
    $output = null;
    $return_var = null;
    exec($command . ' 2>&1', $output, $return_var);

    if ($return_var === 0) {
        if (file_exists($backupFile)) {
            $message = "Backup successful! The backup file is saved at: $backupFile";
        } else {
            $message = "Backup command executed successfully, but the file was not found in $backupDir.";
        }
    } else {
        $message = "Backup failed! Error code: $return_var<br>Output: " . implode("<br>", $output);
    }
}

// Handle the download latest backup request
if (isset($_POST['download_backup'])) {
    $backupDir = '/tmp/';
    $backupFile = find_latest_backup($backupDir);

    if ($backupFile && file_exists($backupFile)) {
        // Set headers to download file
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($backupFile).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($backupFile));
        readfile($backupFile);
        exit;
    } else {
        $message = "Backup file not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Backup</title>
    <script>
        function confirmDownload() {
            return confirm("Are you sure you want to download the latest backup?");
        }
    </script>
</head>
<body>
    <h1>Database Backup</h1>
    <?php if (isset($message)) echo "<p>$message</p>"; ?>
    <form method="post">
        <button type="submit" name="create_backup">Create Backup</button>
        <button type="submit" name="download_backup" onclick="return confirmDownload();">Download Latest Backup</button>
    </form>
</body>
</html>
