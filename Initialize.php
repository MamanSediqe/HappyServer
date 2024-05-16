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
    <form class="row" action="Initialize.php" method="post">
        <input class="buttonExtend" type="submit" name="InitDatabase" value="Init Database" />
        </br>
        <input class="buttonExtend" type="submit" name="RestoreDatabase" value="Restore Database" />
        </br>
        <input class="buttonExtend" type="submit" name="BackupDatabase" value="Backup Database" />
        </br>
        <input class="buttonExtend" type="submit" name="DropTables" value="Drop All Tables" />
        </br>
        <input class="buttonExtend" type="submit" name="Login" value="Login" />
        </br>
    </form>
</body>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //echo "Posted<br>";
    if (isset($_POST['InitDatabase'])) {
        echo "Initializing Links is started";
        require_once 'Links.php';
        $myDB = new LinksDB();
        $myDB->Initialize();
    }
    if (isset($_POST['RestoreDatabase'])) {
        echo "Restoring up Database is started";
        require_once 'Links.php';
        $myDB = new LinksDB();
        $myDB->importSQLFile();
    }


    if (isset($_POST['BackupDatabase'])) {
        echo "Backing up Database is started";
        require_once 'Links.php';
        $myDB = new LinksDB();
        $myDB->exportToDumpFile();
    }

    if (isset($_POST['DropTables'])) {
        echo "Deletting tables";
        require_once 'Links.php';
        $myDB = new LinksDB();
        $myDB->DropTables();
        echo "Done";
    }

    if (isset($_POST['Login'])) {
        echo "Redirect to login";
        header("Location: ./login.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo "Select from menu<br>";
}

?>

</html>