CREATE TABLE workshop_class (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    days INT NOT NULL,
    fees INT NOT NULL -- Assuming fees are in rupees, you can adjust the data type accordingly
);
