
<?php

session_start();

require_once "../includes/database.php";

$errors = [];
$success = "";

$name = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    // Validate name
    if ($name === "") {
        $errors[] = "Name is required.";
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Validate password
    if (strlen($password) < 8) {
        $errors[] = "Password must contain at least 8 characters.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // Register customer
    if (empty($errors)) {

        try {
            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $sql = "INSERT INTO users (name, email, password)
                    VALUES (:name, :email, :password)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ":name" => $name,
                ":email" => $email,
                ":password" => $hashedPassword
            ]);

            $success = "Registration successful! Your customer account has been created.";

            $name = "";
            $email = "";

        } catch (PDOException $e) {

            if ($e->getCode() === "23000") {
                $errors[] = "This email address is already registered.";
            } else {
                error_log($e->getMessage());
                $errors[] = "Something went wrong. Please try again.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Account | Green Mart</title>

    <link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="../assets/css/auth.css">
</head>

<body class="auth-page">

    <div class="auth-container">

        <a href="../index.php" class="logo auth-brand">
            Green Mart<span>.</span>
        </a>

        <div class="auth-card">

            <h1>Create Account</h1>

            <p class="auth-description">
                Join Green Mart and enjoy convenient grocery shopping.
            </p>

            <?php if (!empty($errors)): ?>
                <div class="auth-message">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($success !== ""): ?>
                <div class="auth-message auth-success">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="auth-form">

                <div>
                    <label for="name">Full Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="<?php echo htmlspecialchars($name); ?>"
                        placeholder="Enter your full name"
                        required
                    >
                </div>

                <div>
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo htmlspecialchars($email); ?>"
                        placeholder="Enter your email"
                        required
                    >
                </div>

                <div>
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        minlength="8"
                        placeholder="Create a password"
                        required
                    >
                </div>

                <div>
                    <label for="confirm_password">Confirm Password</label>
                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        minlength="8"
                        placeholder="Confirm your password"
                        required
                    >
                </div>

                <button type="submit" class="btn">
                    Create Account
                </button>

            </form>

            <p class="auth-footer">
                Already have an account?
                <a href="login.php">Login here</a>
            </p>

        </div>

    </div>

</body>
</html>
