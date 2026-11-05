
<?php

session_start();

if (
    !isset($_SESSION["user_id"]) ||
    ($_SESSION["user_role"] ?? "") !== "customer"
) {
    header("Location: login.php");
    exit;
}
$customerName = $_SESSION["user_name"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="../assets/css/account.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Dashboard | Green Mart</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="../assets/css/account.css">
</head>

<body class="account-page">

    <div class="dashboard-layout">

        <!-- Sidebar -->
        <aside class="dashboard-sidebar">

            <a href="../index.php" class="logo">
                Green Mart<span>.</span>
            </a>

            <p class="sidebar-label">MY ACCOUNT</p>

            <nav class="dashboard-nav">
                <a href="dashboard.php" class="active">
                    <span>▦</span> Dashboard
                </a>

                <a href="#profile">
                    <span>👤</span> My Profile
                </a>

                <a href="#orders">
                    <span>📦</span> My Orders
                </a>

                <a href="../index.php#products">
                    <span>🛒</span> Continue Shopping
                </a>
            </nav>

            <div class="sidebar-bottom">
                <a href="logout.php" class="logout-link">
                    <span>↪</span> Logout
                </a>
            </div>

        </aside>

        <!-- Main Content -->
        <main class="dashboard-main">

            <header class="dashboard-header">
                <div>
                    <p class="eyebrow">CUSTOMER DASHBOARD</p>
                    <h1>Welcome back, <?php echo htmlspecialchars($customerName); ?>!</h1>
                    <p>Manage your Green Mart account and shopping activity.</p>
                </div>

                <a href="../index.php" class="btn">
                    Continue Shopping
                </a>
            </header>

            <!-- Overview -->
            <section class="dashboard-section">

                <h2>Account Overview</h2>

                <div class="dashboard-cards">

                    <article class="dashboard-card">
                        <div class="dashboard-card-icon">📦</div>
                        <p>Total Orders</p>
                        <h3>0</h3>
                        <span>No orders placed yet</span>
                    </article>

                    <article class="dashboard-card">
                        <div class="dashboard-card-icon">🛒</div>
                        <p>Shopping Cart</p>
                        <h3>0</h3>
                        <span>Your cart is empty</span>
                    </article>

                    <article class="dashboard-card">
                        <div class="dashboard-card-icon">👤</div>
                        <p>Account Status</p>
                        <h3>Active</h3>
                        <span>Customer account</span>
                    </article>

                </div>

            </section>

            <!-- Profile -->
            <section class="dashboard-section" id="profile">

                <h2>My Profile</h2>

                <div class="profile-card">

                    <div>
                        <p class="profile-label">Full Name</p>
                        <h3><?php echo htmlspecialchars($customerName); ?></h3>
                    </div>

                    <div>
                        <p class="profile-label">Account Type</p>
                        <h3>Customer</h3>
                    </div>

                    <p class="profile-note">
                        Profile editing will be available in a future update.
                    </p>

                </div>

            </section>

            <!-- Orders -->
            <section class="dashboard-section" id="orders">

                <h2>Recent Orders</h2>

                <div class="empty-state">
                    <div class="empty-state-icon">📦</div>
                    <h3>No orders yet</h3>
                    <p>Your grocery orders will appear here after you make a purchase.</p>

                    <a href="../index.php#products" class="btn">
                        Explore Products
                    </a>
                </div>

            </section>

        </main>

    </div>

</body>
</html>
