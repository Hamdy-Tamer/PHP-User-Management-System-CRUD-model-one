<?php
include 'conn.php';

$id = $_GET['id'] ?? 0;

// Fetch user data for the given ID
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <h1>User Details</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h5>
                <p class="card-text"><strong>Phone:</strong> <?php echo $user['phone']; ?></p>
                <p class="card-text"><strong>Email:</strong> <?php echo $user['email']; ?></p>
                <p class="card-text"><strong>Gender:</strong> <?php echo $user['gender']; ?></p>
                <p class="card-text"><strong>Created At:</strong> <?php echo $user['created_at']; ?></p>
                <a href="index.php" class="btn btn-primary">Back to List</a>
            </div>
        </div>
    </div>
</body>
</html>