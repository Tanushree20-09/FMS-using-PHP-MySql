<?php 
session_start();
require("connection.php");

if (isset($_POST['SignUp'])) {
    $username = $_POST['user_name'];
    $password = $_POST['user_password'];
    $email = $_POST['user_email'];
    $phone_number = $_POST['user_phone_number'];

    try {
        // Prepare the SQL statement
        $query = "INSERT INTO `login` (`username`, `password`, `email`, `phone_number`) VALUES (:username, :password, :email, :phone_number)";
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone_number', $phone_number);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Signup successful'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Signup failed');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
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
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .container:hover {
            transform: scale(1.05);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
        }
        .container h2 {
            margin-top: 0;
            color: #333;
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
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .container input:focus {
            outline: none;
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
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
            transition: background-color 0.3s, transform 0.3s;
        }
        .container button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Signup</h2>
        <form action="" method="POST">
            <input type="text" name="user_name" placeholder="Username" required>
            <input type="password" name="user_password" placeholder="Password" required>
            <input type="email" name="user_email" placeholder="Email" required>
            <input type="text" name="user_phone_number" placeholder="Phone Number" required>
            <button type="submit" name="SignUp">Signup</button>
        </form>
    </div>
</body>
</html>
