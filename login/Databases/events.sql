CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    trainer_name VARCHAR(255) NOT NULL,
    tentative_date DATE NOT NULL,
    finalised_date DATE NOT NULL,
    starting_date DATE NOT NULL,
    starting_day VARCHAR(50) NOT NULL,
    number_of_days INT NOT NULL,
    days_option VARCHAR(50) NOT NULL,
    ending_date DATE NOT NULL,
    ending_day VARCHAR(50) NOT NULL,
    timeslot VARCHAR(50) NOT NULL,
    duration_hours DECIMAL(5,2) NOT NULL,
    total_duration_hours DECIMAL(5,2) NOT NULL,
    fees DECIMAL(10,2) NOT NULL
);
