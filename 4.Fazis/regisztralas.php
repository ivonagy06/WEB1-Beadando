<?php
session_start();
require_once 'includes/config.php';

// Ellenőrizzük, hogy a felhasználó már be van-e jelentkezve
if (isset($_SESSION['username'])) {
    echo '
    <div style="background-color: rgba(255, 0, 0, 0.5); padding: 20px; color: white; text-align: center; font-size: 24px;">
        Már be vagy regisztrálva!<br><br>
        <a href="index.php" style="background-color: #007bff; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">Vissza a főoldalra</a>
    </div>';
    exit();
}

// Regisztrációs űrlap elküldése
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Ellenőrizzük, hogy a felhasználónév és az e-mail egyediek legyenek
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Ha a felhasználónév vagy az e-mail már foglalt, hibaüzenet
        echo "A felhasználónév vagy az e-mail már foglalt.";
        exit();
    }

    // Jelszó hashelése
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Felhasználó létrehozása az adatbázisban
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    
    if ($stmt->execute()) {
        // Sikeres regisztráció után irányítás a bejelentkezési oldalra
        header("Location: index.php?oldal=belepes");
        exit();
    } else {
        echo "Hiba történt a regisztráció során.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="pictures/icon.jpg">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="../styles/style.css">
    <style>
        /* Add some basic styling to make it look cool and simple */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .content {
            max-width: 400px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-top: 0;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            height: 40px;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }
        button[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>

    <div class="content">
        <h1>Regisztráció</h1>
        <form action="index.php?oldal=regisztralas" method="post">
            <label for="username">Felhasználónév:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">E-mail cím:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Jelszó:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="register">Regisztráció</button>
        </form>
    </div>
</body>
</html>
