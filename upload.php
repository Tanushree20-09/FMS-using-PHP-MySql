<?php
require 'connection.php'; // Ensure this is the correct path to your connection file

// Handle form submission for file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload') {
    $custom_name = isset($_POST['custom_name']) ? $_POST['custom_name'] : '';
    $subcategory_id = isset($_POST['subcategory_id']) ? (int)$_POST['subcategory_id'] : 0;

    // Generate serial number
    $stmt = $pdo->query('SELECT MAX(serial_number) AS max_serial FROM files');
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $serial_number = $result['max_serial'] + 1;

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['pdf', 'doc', 'docx', 'txt'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadDir = 'uploads/';
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $filePath)) {
                $stmt = $pdo->prepare('INSERT INTO files (serial_number, custom_name, file_name, subcategory_id) VALUES (?, ?, ?, ?)');
                if ($stmt->execute([$serial_number, $custom_name, $fileName, $subcategory_id])) {
                    $message = 'File successfully uploaded and data saved to database.';
                    $success = true;
                } else {
                    $message = 'Failed to save data to database.';
                }
            } else {
                $message = 'Failed to move uploaded file.';
            }
        } else {
            $message = 'Invalid file type.';
        }
    } else {
        $message = 'No file uploaded or upload error.';
    }
}

// Handle file deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $file_id = isset($_POST['file_id']) ? (int)$_POST['file_id'] : 0;
    
    $stmt = $pdo->prepare('SELECT file_name FROM files WHERE id = ?');
    $stmt->execute([$file_id]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($file) {
        $fileName = $file['file_name'];
        $stmt = $pdo->prepare('DELETE FROM files WHERE id = ?');
        if ($stmt->execute([$file_id])) {
            $filePath = 'uploads/' . $fileName;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $message = 'File successfully deleted.';
            $success = true;
        } else {
            $message = 'Failed to delete file from database.';
        }
    } else {
        $message = 'File not found.';
    }
}

// Fetch subcategories for the form
$stmt = $pdo->query('SELECT id, name FROM subcategories');
$subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch files for display
$stmt = $pdo->query('SELECT id, serial_number, custom_name, file_name, uploaded_at FROM files ORDER BY id DESC');
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #2b4353;
        }

        .container {
            padding: 20px;
            max-width: 800px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            position: relative;
        }

        h1 {
            margin-top: 0;
            color: #333;
            font-size: 24px;
        }

        h2 {
            border-bottom: 3px solid #007bff;
            padding-bottom: 8px;
            margin-bottom: 20px;
            color: #333;
            font-size: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        .form-group input[type="file"] {
            border: 1px solid #007bff;
        }

        .form-group button {
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .form-group button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .message {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 6px;
            background-color: #f8d7da;
            color: #721c24;
            font-size: 16px;
            border: 1px solid #f5c6cb;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .files-list {
            margin-top: 20px;
        }

        .files-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .files-list th, .files-list td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .files-list th {
            background-color: #007bff;
            color: white;
            font-size: 16px;
        }

        .files-list tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .files-list tr:hover {
            background-color: #f1f1f1;
        }

        .files-list a {
            color: #007bff;
            text-decoration: none;
        }

        .files-list a:hover {
            text-decoration: underline;
        }

        .delete-button {
            padding: 6px 12px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .delete-button:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

        .home-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            cursor: pointer;
            transition: transform 0.3s, opacity 0.3s;
        }

        .home-icon:hover {
            opacity: 0.8;
        }

        .home-icon.animate {
            transform: scale(1.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="home.jpeg" alt="Home" class="home-icon" id="homeIcon">
        <h1>Upload File</h1>
        <?php if (isset($message)): ?>
            <div class="message <?php echo isset($success) ? 'success' : ''; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="upload">
            <div class="form-group">
                <label for="custom_name">Custom Name:</label>
                <input type="text" id="custom_name" name="custom_name" required>
            </div>
            <div class="form-group">
                <label for="subcategory_id">Subcategory:</label>
                <select id="subcategory_id" name="subcategory_id" required>
                    <?php foreach ($subcategories as $subcategory): ?>
                        <option value="<?php echo htmlspecialchars($subcategory['id']); ?>">
                            <?php echo htmlspecialchars($subcategory['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="file">Choose File:</label>
                <input type="file" id="file" name="file" accept=".pdf,.doc,.docx,.txt" required>
            </div>
            <div class="form-group">
                <button type="submit">Upload File</button>
            </div>
        </form>

        <div class="files-list">
            <h2>Uploaded Files</h2>
            <table>
                <thead>
                    <tr>
                        <th>Serial Number</th>
                        <th>Custom Name</th>
                        <th>File Name</th>
                        <th>Uploaded At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($files as $file): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($file['serial_number']); ?></td>
                            <td><?php echo htmlspecialchars($file['custom_name']); ?></td>
                            <td><a href="uploads/<?php echo htmlspecialchars($file['file_name']); ?>" download><?php echo htmlspecialchars($file['file_name']); ?></a></td>
                            <td><?php echo htmlspecialchars($file['uploaded_at']); ?></td>
                            <td>
                                <form action="upload.php" method="post" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="file_id" value="<?php echo htmlspecialchars($file['id']); ?>">
                                    <button type="submit" class="delete-button">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.getElementById('homeIcon').addEventListener('click', function() {
            const icon = this;
            icon.classList.add('animate');
            setTimeout(() => {
                window.location.href = 'dashboard.php';
            }, 300); // Duration of the animation
        });
    </script>
</body>
</html>
