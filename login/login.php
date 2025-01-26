<?php 
session_start();

include("connection.php");
include("functions.php");

// Hardcoded credentials
$correct_user_name = "user@example.com";
$correct_password = "password123";

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    // Something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if($user_name == $correct_user_name && $password == $correct_password)
    {
        // Credentials are correct
        $_SESSION['user_id'] = random_num(20); // Random session ID
        header("Location: index.php");
        die;
    }
    else
    {
        echo "Wrong username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style type="text/css">
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        #box {
            background-color: lightpink;
            width: 300px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #text {
            height: 25px;
            border-radius: 5px;
            padding: 4px;
            border: solid thin #aaa;
            width: 100%;
        }

        #button {
            padding: 10px;
            width: 100px;
            color: white;
            background-color: lightblue;
            border: none;
            border-radius: 5px;
        }

        #header {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .form-title {
            font-size: 20px;
            margin: 10px;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="header">Event Scheduling System</div>
    <div id="box">
        <form method="post">
            <div class="form-title">Login</div>
            <input id="text" type="text" name="user_name" placeholder="Email"><br><br>
            <input id="text" type="password" name="password" placeholder="Password"><br><br>
            <input id="button" type="submit" value="Login"><br><br>
        </form>
    </div>
</body>
</html>
