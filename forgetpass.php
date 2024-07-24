<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
            font-family: 'Arial', sans-serif;
            background:  linear-gradient(135deg, #93A5CF, #E4EfE9);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            box-sizing: border-box;
            animation: fadeInUp 1s ease-out;
        }
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
            border: 1px solid black;
            
        }
        .container:hover {
            transform: scale(1.05);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
        }
        .container img {
            max-width: 70%;
            height: auto;
            margin-bottom: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .container h2 {
            margin-top: 0;
            color: #007BFF;
        }
        .container form {
            display: flex;
            flex-direction: column;
        }
        .container input {
            margin-bottom: 15px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease;
        }
        .container input:focus {
            border-color: #007BFF;
        }
        .container button {
            padding: 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form action="" method="post">
            <input type="text" name="email_or_phone" placeholder="Enter your email address or phone number" required>
            <button type="submit">Send Reset Link</button>
        </form>

        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require("connection.php");
    $input = $_POST['email_or_phone'];

    try {
        // Check if the input is an email or phone number
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            // It's an email
            $query = "SELECT * FROM `login` WHERE `email` = :input";
            $type = "email";
        } else {
            // Assume it's a phone number
            $query = "SELECT * FROM `login` WHERE `phone_number` = :input";
            $type = "phone number";
        }

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':input', $input);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Simulate sending reset link
            echo "<p style='color: green;'>A password reset link has been sent to your $type.</p>";
        } else {
            // Input does not exist in the database
            echo "<p style='color: red;'>This $type is not registered in our system.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>
    </div>
</body>
</html>
  