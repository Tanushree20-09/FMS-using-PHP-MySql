<?php
if (isset($_GET['name'])) {
    $fileName = $_GET['name'];
    $filePath = 'policy/' . $fileName;

    if (file_exists($filePath)) {
        unlink($filePath);

        $fileData = json_decode(file_get_contents('files.json'), true);
        $fileData = array_filter($fileData, function($file) use ($fileName) {
            return $file['name'] !== $fileName;
        });

        file_put_contents('files.json', json_encode($fileData));
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
