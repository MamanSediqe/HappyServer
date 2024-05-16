<?php
require_once "Links.php";

$myDB = new LinksDB();
$conn =$myDB->conn;

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch all Happy links
function getAllLinkValues($conn) {
    $sql = "SELECT LinkValue FROM Links ORDER BY LinkTitle";
    $result = $conn->query($sql);
    $LinkValues = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $LinkValues[] = $row['LinkValue'];
        }
    }
    return $LinkValues;
}

// Get all Happy links
$LinkValues = getAllLinkValues($conn);

// Close the database connection
$conn->close();

// Set the content type to plain text
header('Content-Type: text/plain');

// Output the Happy links separated by newline characters
echo implode("\n", $LinkValues);
?>
