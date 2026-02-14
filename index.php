<?php
include 'conn.php';
session_start();

// Check if there's an alert message in session
if (isset($_SESSION['alert'])) {
    $alert = $_SESSION['alert'];
    unset($_SESSION['alert']);
} else {
    $alert = "";
}

// Check for validation errors
$errors = $_SESSION['errors'] ?? [];
$old_input = $_SESSION['old_input'] ?? [];

// Clear session errors after retrieving
unset($_SESSION['errors']);
unset($_SESSION['old_input']);

// Fetch all users from the database
$sql = "SELECT * FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">User Management System</h1>
        
        <!-- Display Alert -->
        <?php if (!empty($alert)): ?>
            <?php echo $alert; ?>
        <?php endif; ?>

        <!-- Form for adding new users -->
        <div class="row mt-4">
            <div class="col-md-6">
                <h2>Add New User</h2>
                <form action="add.php" method="POST">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control <?php echo isset($errors['first_name']) ? 'is-invalid' : ''; ?>" 
                               id="first_name" name="first_name" 
                               value="<?php echo htmlspecialchars($old_input['first_name'] ?? ''); ?>">
                        <?php if (isset($errors['first_name'])): ?>
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> <?php echo $errors['first_name']; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control <?php echo isset($errors['last_name']) ? 'is-invalid' : ''; ?>" 
                               id="last_name" name="last_name" 
                               value="<?php echo htmlspecialchars($old_input['last_name'] ?? ''); ?>">
                        <?php if (isset($errors['last_name'])): ?>
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> <?php echo $errors['last_name']; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control <?php echo isset($errors['phone']) ? 'is-invalid' : ''; ?>" 
                               id="phone" name="phone" 
                               value="<?php echo htmlspecialchars($old_input['phone'] ?? ''); ?>">
                        <?php if (isset($errors['phone'])): ?>
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> <?php echo $errors['phone']; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
                               id="email" name="email" 
                               value="<?php echo htmlspecialchars($old_input['email'] ?? ''); ?>">
                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> <?php echo $errors['email']; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Gender</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input <?php echo isset($errors['gender']) ? 'is-invalid' : ''; ?>" 
                                   type="radio" name="gender" id="male" value="Male" 
                                   <?php echo (isset($old_input['gender']) && $old_input['gender'] == 'Male') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input <?php echo isset($errors['gender']) ? 'is-invalid' : ''; ?>" 
                                   type="radio" name="gender" id="female" value="Female"
                                   <?php echo (isset($old_input['gender']) && $old_input['gender'] == 'Female') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input <?php echo isset($errors['gender']) ? 'is-invalid' : ''; ?>" 
                                   type="radio" name="gender" id="other" value="Other"
                                   <?php echo (isset($old_input['gender']) && $old_input['gender'] == 'Other') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="other">Other</label>
                        </div>
                        <?php if (isset($errors['gender'])): ?>
                            <div class="invalid-feedback d-block" style="display: block !important; margin-top: 10px;">
                                <i class="fas fa-exclamation-circle"></i> <?php echo $errors['gender']; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
        </div>

        <!-- Table to display users -->
        <div class="row mt-5">
            <div class="col-12">
                <h2>User List</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['first_name']; ?></td>
                                    <td><?php echo $row['last_name']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['gender']; ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td>
                                        <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                        <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No users found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>