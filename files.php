<?php
require 'connection.php';

// Get parameters
$subcategory_id = isset($_GET['subcategory_id']) ? intval($_GET['subcategory_id']) : 0;
$year = isset($_GET['year']) ? intval($_GET['year']) : 0;

try {
    // Prepare SQL statement
    $stmt = $pdo->prepare("
        SELECT id, serial_number, custom_name, file_name, uploaded_at
        FROM files
        WHERE subcategory_id = :subcategory_id
        AND YEAR(uploaded_at) = :year
        ORDER BY uploaded_at DESC
    ");
    $stmt->execute(['subcategory_id' => $subcategory_id, 'year' => $year]);

    // Fetch all results
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are results
    if ($files) {
        echo '<table>
                <thead>
                    <tr>
                        <th>SL NO</th>
                        <th>Custom Name</th>
                        <th>File Name</th>
                        <th>Date Uploaded</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($files as $file) {
            echo '<tr>
                    <td>' . htmlspecialchars($file['serial_number']) . '</td>
                    <td>' . htmlspecialchars($file['custom_name']) . '</td>
                    <td>' . htmlspecialchars($file['file_name']) . '</td>
                    <td>' . htmlspecialchars(date('d-m-Y H:i:s', strtotime($file['uploaded_at']))) . '</td>
                    <td><a href="uploads/' . htmlspecialchars($file['file_name']) . '" download>Download</a></td>
                  </tr>';
        }

        echo '   </tbody>
            </table>';
    } else {
        echo '<p>No files available for the selected year.</p>';
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
