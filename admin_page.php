<?php

require_once 'Links.php';
$myDB = new LinksDB();

$valid_passwords = array("admin" => "12346");
$valid_users = array_keys($valid_passwords);

$user = @$_SERVER['PHP_AUTH_USER'];
$pass = @$_SERVER['PHP_AUTH_PW'];

$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

if (!$validated) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    die("Not authorized");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>
        Server Manager
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/mainStyle.css">
    <script>
        function confirmRestore() {
            return confirm("Are you sure you want to restore database?\n All data will be lost");
        }
    </script>
</head>

<body style="direction: ltr;">
    <form class="row" action="admin_page.php" method="post">
        <input class="buttonExtend" type="submit" name="InitDatabase" value="Init <?php echo $myDB->dbName ?> Database" />
        </br>
        <input class="buttonExtend" type="submit" name="BackupDatabase" value="Backup Database" />
        </br>
        <input class="buttonExtend" type="submit" name="DownloadBackup" value="Download Latest Backup" />
        </br>
        <button class="buttonExtend" type="submit" name="RestoreDatabase" onclick="return confirmRestore();">Restore Database</button>
        </br>
        <input class="buttonExtend" type="submit" name="DropTables" value="Drop All Tables" />
        </br>
        <input class="buttonExtend" type="submit" name="LinksManager" value="Links Manager" />
        </br>
        <input class="buttonExtend" type="submit" name="ParametersManager" value="Parameters Manager" />
        </br>
        <input class="buttonExtend" type="submit" name="ServerLog" value="View server log" />
        </br>
        <input class="buttonExtend" type="submit" name="Logout" value="Logout" />
        </br>
    </form>
    
    <?php if (isset($message)) echo "<p>$message</p>"; ?>
</body>

</html>

<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['username'] == null) {
    header("Location: ./login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //echo "Posted<br>";
    if (isset($_POST['InitDatabase'])) {
        echo "Initializing Links is started<br/>";
        $myDB->Initialize();
    }
    /*
    if (isset($_POST['BackupDatabase'])) {
        echo "Backing up Database is started<br/>";
        $myDB->exportToDumpFile();
    }
*/
    if (isset($_POST['RestoreDatabase'])) {
        echo "Restoring up Database is started<br/>";
        $myDB->importSQLFile();
    }

    if (isset($_POST['DropTables'])) {
        $myDB->DropTables();
        echo "Done";
    }

    if (isset($_POST['LinksManager'])) {

        header("Location: ./linksManager.php");
    }
    if (isset($_POST['ParametersManager'])) {

        header("Location: ./parametersManager.php");
    }
    if (isset($_POST['ServerLog'])) {

        header("Location: ./logReport.php");
    }
    if (isset($_POST['Logout'])) {
        $_SESSION['username'] = null;
        header("Location: ./login.php");
        exit();
    }

    // Handle the create backup request
    if (isset($_POST['BackupDatabase'])) {
        $conn = $myDB->conn;

        $backupDir = '/tmp/';
        $backupFile = $backupDir . 'happy_db_backup_' . date('Y-m-d') . '.sql';


        // Command to backup database (fixed spaces in the command)
        $command = "mysqldump --user={$myDB->username} --password={$myDB->password} --host=$servername {$myDB->dbName} > $backupFile";

        // Execute the command and check for success
        $output = null;
        $return_var = null;
        exec($command . ' 2>&1', $output, $return_var);

        if ($return_var === 0) {
            if (file_exists($backupFile)) {
                $message = "Backup successful! <br/>The backup file is saved at: $backupFile";
            } else {
                $message = "Backup command executed successfully, but the file was not found in $backupDir.";
            }
        } else {
            $message = "Backup failed!  <br/>Error code: $return_var<br>Output: " . implode("<br>", $output);
        }
        echo $message;
    }

    // Handle the download latest backup request
    if (isset($_POST['DownloadBackup'])) {
        $backupDir = '/tmp/';
        $backupFile = find_latest_backup($backupDir);

        if ($backupFile && file_exists($backupFile)) {
            // Set headers to download file
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($backupFile) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($backupFile));
            readfile($backupFile);
            exit;
        } else {
            $message = "Backup file not found.";
        }
        echo $message;
    }
} // Function to find the latest backup file
function find_latest_backup($dir)
{
    $files = glob($dir . 'happy_db_backup_*.sql');
    if (!$files) {
        return false;
    }
    // Sort files by modification time, newest first
    usort($files, function ($a, $b) {
        return filemtime($b) - filemtime($a);
    });
    return $files[0];
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo "Select from menu<br>";
}

?>