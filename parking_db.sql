-- Create a table for parking reservations
CREATE TABLE parking_reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parking_number INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    reservation_time DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);