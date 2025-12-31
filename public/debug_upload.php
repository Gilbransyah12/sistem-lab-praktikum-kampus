<?php
// debug_upload.php

$message = '';
$fileInfo = [];
$serverInfo = [
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'memory_limit' => ini_get('memory_limit'),
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['test_file'])) {
        $file = $_FILES['test_file'];
        $errorCode = $file['error'];
        
        $errorMessages = [
            0 => 'UPLOAD_ERR_OK: File uploaded successfully.',
            1 => 'UPLOAD_ERR_INI_SIZE: File exceeds upload_max_filesize in php.ini.',
            2 => 'UPLOAD_ERR_FORM_SIZE: File exceeds MAX_FILE_SIZE directive in HTML form.',
            3 => 'UPLOAD_ERR_PARTIAL: The uploaded file was only partially uploaded.',
            4 => 'UPLOAD_ERR_NO_FILE: No file was uploaded.',
            6 => 'UPLOAD_ERR_NO_TMP_DIR: Missing a temporary folder.',
            7 => 'UPLOAD_ERR_CANT_WRITE: Failed to write file to disk.',
            8 => 'UPLOAD_ERR_EXTENSION: A PHP extension stopped the file upload.',
        ];

        $message = $errorMessages[$errorCode] ?? 'Unknown Error';
        $fileInfo = $file;
    } else {
        $message = "POST request received but no file found. Likely explicitly blocked by 'post_max_size' or Nginx 'client_max_body_size'.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Debug Upload</title>
    <style>
        body { font-family: monospace; padding: 2rem; }
        .success { color: green; }
        .error { color: red; font-weight: bold; }
        table { border-collapse: collapse; width: 100%; max-width: 600px; margin-top: 1rem; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h1>Upload Debugger</h1>
    
    <h3>Current PHP Config (Loaded)</h3>
    <ul>
        <li>upload_max_filesize: <strong><?= $serverInfo['upload_max_filesize'] ?></strong></li>
        <li>post_max_size: <strong><?= $serverInfo['post_max_size'] ?></strong></li>
    </ul>

    <?php if ($message): ?>
        <div class="<?= isset($fileInfo['error']) && $fileInfo['error'] === 0 ? 'success' : 'error' ?>">
            <h3>Result:</h3>
            <p><?= $message ?></p>
            <?php if (!empty($fileInfo)): ?>
                <pre><?= print_r($fileInfo, true) ?></pre>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <hr>
    
    <form method="POST" enctype="multipart/form-data">
        <label>Try uploading your file (4MB PDF):</label><br><br>
        <input type="file" name="test_file"><br><br>
        <button type="submit">Test Upload</button>
    </form>
</body>
</html>
