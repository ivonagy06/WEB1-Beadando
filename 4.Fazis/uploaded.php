<?php
session_start();
require_once('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $uploadDir = 'pictures/';
    $uploadedBy = isset($_SESSION['username']) ? $_SESSION['username'] : 'Vendég'; // Use 'Vendég' if not logged in
    $imageName = basename($_FILES['image']['name']);
    $uploadFile = $uploadDir . $imageName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        // Use MySQLi to insert the record
        $stmt = $conn->prepare("INSERT INTO uploaded_images (uploaded_by, image_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $uploadedBy, $imageName);

        if ($stmt->execute()) {
            $uploadSuccess = true;
        } else {
            $uploadError = "Failed to insert record into database: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $uploadError = "Possible file upload attack!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="pictures/icon.jpg">
    <title>Upload Image</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        input[type="file"] {
            margin: 10px 0;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            color: #0056b3;
        }
        .message {
            margin: 20px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upload Image</h1>
        <?php if (isset($uploadSuccess) && $uploadSuccess): ?>
            <div class="message success">File is valid, and was successfully uploaded.</div>
        <?php elseif (isset($uploadError)): ?>
            <div class="message error"><?= htmlspecialchars($uploadError) ?></div>
        <?php endif; ?>
        <form action="index.php?oldal=uploaded" method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="image" id="image">
            <input type="submit" value="Upload Image" name="submit">
        </form>
        <a href="index.php">Főoldalra</a>
    </div>
</body>
</html>
