<?php

require_once 'Links.php';
$myDB = new LinksDB();
?>
<!DOCTYPE html>
<html>

<head>
    <title>
        Happy Manager
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/mainStyle.css">
</head>

<body style="direction: ltr;">
    <form class="row" action="admin_page.php" method="post">
        <input class="buttonExtend" type="submit" name="InitDatabase" value="Init <?php echo $myDB->dbName ?> Database" />
        </br>
        <input class="buttonExtend" type="submit" name="BackupDatabase" value="Backup Database" />
        </br>
        <input class="buttonExtend" type="submit" name="RestoreDatabase" value="Restore Database" />
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
</body>
</html>

<?php 
if (!isset($_SESSION)) 
{
    session_start();
}
if ($_SESSION['username'] == null) 
{
    header("Location: ./login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //echo "Posted<br>";
    if (isset($_POST['InitDatabase'])) {
        echo "Initializing Links is started<br/>";
        $myDB->Initialize();
    }

    if (isset($_POST['BackupDatabase'])) {
        echo "Backing up Database is started<br/>";
        $myDB->exportToDumpFile();
    }

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
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo "Select from menu<br>";
}

?>