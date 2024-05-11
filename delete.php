<?php
// Include database connection file
require_once 'db_connection.php';

// Check if ID parameter is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete record from database
    $sql = "DELETE FROM parking_reservations WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
