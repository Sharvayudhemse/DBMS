<?php
// Include database connection file
require_once 'db_connection.php';

// Check if ID parameter is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve reservation details
    $sql = "SELECT * FROM parking_reservations WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // Update reservation
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $parking_number = $_POST['parking_number'];
        $name = $_POST['name'];
        $reservation_time = $_POST['reservation_time'];

        // Update record in database
        $update_sql = "UPDATE parking_reservations SET parking_number='$parking_number', name='$name', reservation_time='$reservation_time' WHERE id=$id";
        if (mysqli_query($conn, $update_sql)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
} else {
    echo "Invalid request.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Parking Reservation</title>
</head>
<body>
    <h1>Edit Parking Reservation</h1>
    <form method="post" action="">
        <label for="parking_number">Parking Number:</label>
        <input type="text" name="parking_number" id="parking_number" value="<?php echo $row['parking_number']; ?>" required><br><br>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $row['name']; ?>" required><br><br>
        <label for="reservation_time">Reservation Time:</label>
        <input type="datetime-local" name="reservation_time" id="reservation_time" value="<?php echo date('Y-m-d\TH:i', strtotime($row['reservation_time'])); ?>" required><br><br>
        <input type="submit" value="Update Reservation">
    </form>
</body>
</html>