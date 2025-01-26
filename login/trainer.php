<!DOCTYPE html>
<html>
<head>
    <title>Trainer Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .form-container {
            width: 50%;
            margin: auto;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .form-container h3 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 32px; /* Larger font size */
            color: #ff6347; /* Bright font color */
        }
        .form-container label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container select {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .success-message {
            color: green;
            text-align: center;
            margin-top: 20px;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h3>Trainer Registration Form</h3>
        <?php
        // Check if success parameter is set in URL
        if (isset($_GET['success']) && $_GET['success'] == 'true') {
            echo "<p style='color: green;'>Trainer registered successfully.</p>";
        }
        ?>
        <form method="POST" action="process_trainer.php">
            <!-- Form fields -->
			  <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="father_husband_name">Father/Husband Name:</label>
            <input type="text" id="father_husband_name" name="father_husband_name" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
