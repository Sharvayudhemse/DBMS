<?php
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $parking_number = $_POST['parking_number'];
    $name = $_POST['name'];
    $reservation_time = $_POST['reservation_time'];

    if (strtotime($reservation_time) < time()) 
    {
        echo "Error: Reservation time cannot be in the past.";
    } 
    else 
    {
        $check_sql = "SELECT reservation_time FROM parking_reservations WHERE parking_number = '$parking_number' ORDER BY reservation_time DESC LIMIT 1";
        $check_result = mysqli_query($connection, $check_sql);

        if (mysqli_num_rows($check_result) > 0) 
        {
            $last_reservation_time = strtotime(mysqli_fetch_assoc($check_result)['reservation_time']) + 3600;
            if (strtotime($reservation_time) < $last_reservation_time) 
            {
                echo "Error: There must be at least 1 hour between reservations for the same parking slot.";
            } 
            else 
            {
                $sql = "INSERT INTO parking_reservations (parking_number, name, reservation_time) VALUES ('$parking_number', '$name', '$reservation_time')";
                if (mysqli_query($connection, $sql)) 
                {
                    echo "Reservation added successfully.";
                } else 
                {
                    echo "Error: " . mysqli_error($connection);
                }
            }
        } 
        else 
        {
            $sql = "INSERT INTO parking_reservations (parking_number, name, reservation_time) VALUES ('$parking_number', '$name', '$reservation_time')";
            if (mysqli_query($connection, $sql)) 
            {
                echo "Reservation added successfully.";
            } else 
            {
                echo "Error: " . mysqli_error($connection);
            }
        }
    }
}

$sql = "SELECT * FROM parking_reservations";
$result = mysqli_query($connection, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parking Management System</title>
</head>
<body>
    <h1>Parking Management System</h1>
    <form method="post" action="">
        <label for="parking_number">Parking Number:</label>
        <select name="parking_number" id="parking_number">
            <?php for ($i = 1; $i <= 10; $i++) { echo "<option value='$i'>$i</option>"; } ?>
        </select><br><br>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>
        <label for="reservation_time">Reservation Time:</label>
        <input type="datetime-local" name="reservation_time" id="reservation_time" required><br><br>
        <input type="submit" value="Reserve Parking">
    </form>

    <h2>Parking Reservations</h2>
    <?php if (mysqli_num_rows($result) > 0) { ?>
        <table border='1'>
            <tr><th>ID</th><th>Parking Number</th><th>Name</th><th>Reservation Time</th><th>Actions</th></tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['parking_number'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['reservation_time'] ?></td>
                    <td><a href='edit.php?id=<?= $row['id'] ?>'>Edit</a> | <a href='delete.php?id=<?= $row['id'] ?>'>Delete</a></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else {
        echo "No reservations found.";
    } ?>
</body>
</html>
