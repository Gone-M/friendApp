<?php
$servername = "localhost";
$port = "8889";
$username = "root";
$password = "root";
$dbname = "db";

try {
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["profile-picture"]) && $_FILES["profile-picture"]["error"] == 0) {
        $target_dir = __DIR__ . "/uploads/";
        $target_file = $target_dir . basename($_FILES["profile-picture"]["name"]);

        if ($_FILES["profile-picture"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            exit();
        }

        $allowed_types = array("jpg", "jpeg", "png", "gif");
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($file_type, $allowed_types)) {
            echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
            exit();
        }

        if (move_uploaded_file($_FILES["profile-picture"]["tmp_name"], $target_file)) {
            $file_path = $target_file;

            $stmt = $conn->prepare("UPDATE users SET profile_picture = :profile_picture WHERE id = :id");
            $stmt->bindParam(':profile_picture', $file_path);
            $stmt->bindParam(':id', $_SESSION['user_id']);
            $stmt->execute();

            echo "The file " . htmlspecialchars(basename($_FILES["profile-picture"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "No file uploaded.";
    }
} else {
    header("Location: profile.php");
    exit();
}
?>

