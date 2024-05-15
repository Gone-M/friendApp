<?php
$servername = "localhost";
$port = "8889";
$username = "root";
$password = "root";
$dbname = "db";

try {
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .profile-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .profile-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            color: #333;
        }
        .profile-info {
            margin-bottom: 20px;
        }
        .profile-info label {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="profile-container">
        <h2 class="profile-title">User Profile</h2>
        <div class="profile-info">
            <label>Username:</label>
            <p><?php echo isset($user['username']) ? htmlspecialchars($user['username']) : 'Unknown'; ?></p>
        </div>
        <div class="profile-info">
            <label>Location:</label>
            <p><?php echo isset($user['location']) ? htmlspecialchars($user['location']) : 'Unknown'; ?></p>
        </div>
        <!-- Profile Picture Upload Form -->
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="profile-picture">Profile Picture:</label>
                <input type="file" class="form-control-file" id="profile-picture" name="profile-picture">
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
        <!-- Add more profile information here -->
        <div class="text-center mt-3">
            <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>
</body>
</html>

