<?php
session_start();
require("connection.php");

if (isset($_POST['LogIn'])) {
    $username = $_POST['user_name'];
    $password = $_POST['user_password'];

    try {
        $query = "SELECT * FROM `login` WHERE `username` = :username AND `password` = :password";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $_SESSION['username'] = $username;
            echo "<script>alert('Login successful'); window.location.href = 'filemanagement.php';</script>";
        } else {
            echo "<script>alert('Incorrect Username or Password');</script>";
        }
    } catch (PDOException $e) {
        echo 'Query failed: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #93A5CF, #E4EfE9);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            animation: fadeInUp 1s ease-out;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 300px;
            max-width: 100%;
            text-align: center;
            position: relative; /* Added for positioning the image */
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .container:hover {
            transform: scale(1.05);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
        }
        .container h2 {
            margin-top: 0;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container h2 img {
            margin-right: 10px;
            width: 40px; /* Adjust size as needed */
            height: auto;
        }
        .container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container input {
            margin-bottom: 15px;
            padding: 12px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .container input:focus {
            outline: none;
            border-color: #007BFF;
        }
        .container button {
            padding: 12px;
            width: 100%;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-top: 15px; /* Added margin for spacing */
        }
        .container button:hover {
            background-color: #0056b3;
        }
        .container .links {
            margin-top: 15px;
            font-size: 14px;
        }
        .container .links a {
            color: #007BFF;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s;
        }
        .container .links a:hover {
            color: #0056b3;
        }
        .container .signup-link {
            margin-top: 15px;
            font-size: 14px;
        }
        .container .signup-link a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s;
        }
        .container .signup-link a:hover {
            color: #007BFF;
        }
        .back-button {
            position: absolute;
            top: 10px;
            right: 55px; /* Adjust this value based on the logout button position */
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <a href="dashboard.php" class="back-button">Back</a>
    <div class="container">
        <h2><img src="logo.png" alt="Logo">ADMIN PANEL</h2>
        <form action="" method="POST">
            <input type="text" name="user_name" placeholder="Username" required>
            <input type="password" name="user_password" placeholder="Password" required>
            <button type="submit" name="LogIn">Login</button>
        </form>
        <div class="links">
            <a href="forgotpassword.php">Forgot Password?</a>
        </div>
        <div class="signup-link">
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>
</body>
</html>
