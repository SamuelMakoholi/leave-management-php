<?php
// Start session
session_start();

include 'includes/db.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validate inputs here

    // Check if the username already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user) {
        $errors[] = "Username already exists. Please choose a different username.";
    } else {
        // Insert the user into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, username, password, role) VALUES (:name, :username, :password, :role)");
        $result = $stmt->execute([
            'name' => $name,
            'username' => $username,
            'password' => $hashedPassword,
            'role' => $role
        ]);

        if ($result) {
            // User successfully registered
            header("Location: registration_success.php");
            exit();
        } else {
            $errors[] = "Failed to register user. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Leave Application System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="login-container">
    <h3>User Registration</h3>
    <form action="register.php" method="post">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" required>
                <option value="admin">Admin</option>
                <option value="supervisor">Supervisor</option>
                <option value="employee">Employee</option>
            </select>
        </div>
        <?php foreach ($errors as $error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="index.php">Login here</a></p>
</div>

</body>
</html>