
<?php

session_start();

require_once "../includes/database.php";

$error = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {
        $error = "Please enter your email and password.";
    } else {

        $sql = "SELECT id, name, email, password, role
                FROM users
                WHERE email = :email
                LIMIT 1";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([":email" => $email]);

        $user = $stmt->fetch();

        if (
            $user &&
            $user["role"] === "customer" &&
            password_verify($password, $user["password"])
        ) {

            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_role"] = $user["role"];

            header("Location: dashboard.php");
            exit;

        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Login | Groco</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>

<body class="auth-page">

    <div class="auth-container">

        <a href="../index.php" class="logo auth-brand">
            Groco<span>.</span>
        </a>

        <div class="auth-card">

            <h1>Welcome Back!</h1>

            <p class="auth-description">
                Login to your Groco account.
            </p>

            <?php if ($error !== ""): ?>
                <div class="auth-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="auth-form">

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
                        placeholder="Enter your password"
                        required
                    >
                </div>

                <button type="submit" class="btn">
                    Login
                </button>

            </form>

            <p class="auth-footer">
                Don't have an account?
                <a href="register.php">Create an account</a>
            </p>

        </div>

    </div>

</body>
</html>
