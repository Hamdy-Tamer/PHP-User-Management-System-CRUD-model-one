<?php
session_start();
include 'conn.php';

$id = $_GET['id'] ?? 0;

// Delete user
$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Success! User deleted successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
} else {
    $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Error! Failed to delete user.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
}

$_SESSION['alert'] = $alert;

$stmt->close();
$conn->close();

header("Location: index.php");
exit();
?>