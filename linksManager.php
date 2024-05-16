<?php
require_once "LinksDb.php";
// Create connection
$myDB = new LinksDB();
$conn = $myDB->conn;

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Function to update Link record
function updateLink($conn, $id, $title, $link)
{
    $sql = "UPDATE Links SET LinkTitle='$title', LinkValue='$link' WHERE LinkId=$id";
    $conn->query($sql);
}

// Function to add a new Link record
function addLink($conn, $title, $link)
{
    $nextId = getNextId($conn);
    $sql = "INSERT INTO Links (LinkId, LinkTitle, LinkValue) VALUES ('$nextId', '$title', '$link')";
    $conn->query($sql);
}

// Function to get the next available LinkId
function getNextId($conn)
{
    $sql = "SELECT MAX(LinkId) AS maxId FROM Links";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['maxId'] + 1;
    } else {
        return 1; // If no records exist, start with ID 1
    }
}

// Function to delete a Link record
function deleteLink($conn, $id)
{
    $sql = "DELETE FROM Links WHERE LinkId=$id";
    $conn->query($sql);
}

// Handling form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["edit"])) {
        $id = $_POST["id"];
        $title = $_POST["title"];
        $link = $_POST["link"];
        updateLink($conn, $id, $title, $link);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } elseif (isset($_POST["delete"])) {
        $id = $_POST["id"];
        deleteLink($conn, $id);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } elseif (isset($_POST["add"])) {
        $title = $_POST["newTitle"];
        $link = $_POST["newLink"];
        addLink($conn, $title, $link);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}
// Fetch all Link records
$Links =$myDB->getAllLinks($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
        }

        form {
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 48%;
        }

        .delete-button {
            background-color: #ff3333;
            width: 48%;
        }

        button:hover,
        .delete-button:hover {
            opacity: 0.8;
        }
    </style>
    <script>
        function confirmAction() {
            return confirm("Are you sure you want to do this?");
        }
    </script>
</head>

<body>

    <h2 style="text-align:center ;">Links List</h2>
    <!-- Form to add a new Link record -->
    <form method="post" action="">
        <div class="flex-container">
            <label for="newTitle">Title (max 20 chars):</label>
            <input type="text" name="newTitle" required maxlength="20">
            <button type="submit" name="add">Add</button>
        </div>
        <label for="newLink">Link (max 1024 chars):</label>
        <textarea name="newLink" rows="4" required maxlength="1024"></textarea>
    </form>

    <!-- Display Link records -->
    <ul>
        <?php foreach ($Links as $Link) : ?>
            <li>
                <form method="post" action="" onsubmit="return confirmAction();">
                    <div class="flex-container">
                        <label for="title">Title:</label>
                        <input type="text" name="title" value="<?= $Link["LinkTitle"] ?>" maxlength="20">
                        <button type="submit" name="edit">Save</button>
                        <button type="submit" name="delete" class="delete-button">Delete</button>
                    </div>
                    <label for="link">Link:</label>
                    <textarea name="link" rows="4" maxlength="1024"><?= $Link["LinkValue"] ?></textarea>
                    <input type="hidden" name="id" value="<?= $Link["LinkId"] ?>">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>

</html>
