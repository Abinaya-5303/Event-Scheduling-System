<?php
session_start();
include("connection.php");
include("functions.php");
check_login($con);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Workshop/Class Form</title>
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
        .form-container .input-label {
            display: block;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 24px; /* Larger font size for labels */
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h3>Events</h3>
        <form method="POST">
            <div class="input-label">1. Workshop</div>
            <div class="input-label">2. Class</div>
			
        </form>
    </div>
</body>
</html>
