<?php
require_once('includes/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="pictures/icon.jpg">
    <title>Messages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        .message-container {
            width: 80%;
            max-width: 800px;
            margin-bottom: 20px;
        }
        .message {
            background-color: white;
            padding: 20px;
            margin: 10px 0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .message .username {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .message .created-at {
            font-size: 0.8em;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Messages</h1>
    <div class="message-container">
        <?php
        $result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="message">';
                echo '<div class="username">' . htmlspecialchars($row['username']) . '</div>';
                echo '<div class="created-at">' . htmlspecialchars($row['created_at']) . '</div>';
                echo '<div class="content">' . nl2br(htmlspecialchars($row['message'])) . '</div>';
                echo '</div>';
            }
        } else {
            echo "No messages yet.";
        }
        ?>
    </div>
    <a href="index.php?oldal=messages">Submit Another Message</a>
</body>
</html>
