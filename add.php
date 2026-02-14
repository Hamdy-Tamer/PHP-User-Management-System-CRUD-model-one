<?php
session_start();
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $gender = $_POST['gender'] ?? '';

    // Validate required fields
    if (empty($first_name)) {
        $errors['first_name'] = 'First name is required';
    }
    
    if (empty($last_name)) {
        $errors['last_name'] = 'Last name is required';
    }
    
    if (empty($phone)) {
        $errors['phone'] = 'Phone number is required';
    }
    
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    }
    
    if (empty($gender)) {
        $errors['gender'] = 'Please select a gender';
    }

    // If there are validation errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_input'] = $_POST;
        header("Location: index.php");
        exit();
    }

    // Check for unique phone and email
    $check_sql = "SELECT id FROM users WHERE phone = ? OR email = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ss", $phone, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Phone or email already exists
        $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> Error! Phone number or email already exists.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        $_SESSION['alert'] = $alert;
        $_SESSION['old_input'] = $_POST;
        header("Location: index.php");
        exit();
    } else {
        // Insert new user
        $insert_sql = "INSERT INTO users (first_name, last_name, phone, email, gender) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sssss", $first_name, $last_name, $phone, $email, $gender);

        if ($stmt->execute()) {
            $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> Success! User added successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            $_SESSION['alert'] = $alert;
            // Clear old input on success
            unset($_SESSION['old_input']);
        } else {
            $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> Error! Failed to add user.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            $_SESSION['alert'] = $alert;
            $_SESSION['old_input'] = $_POST;
        }
    }

    $stmt->close();
    $conn->close();

    header("Location: index.php");
    exit();
}
?>