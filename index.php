
<?php
$pageTitle = "Green Mart | Fresh Groceries";
?>

<?php

require_once __DIR__ . "/includes/database.php";

try {
    $stmt = $pdo->prepare("
        SELECT
            products.id,
            products.name,
            products.slug,
            products.description,
            products.price,
            products.stock_quantity,
            products.image,
            categories.name AS category_name
        FROM products
        INNER JOIN categories
            ON products.category_id = categories.id
        WHERE products.is_active = 1
          AND categories.is_active = 1
        ORDER BY products.created_at DESC
    ");

    $stmt->execute();

    $products = $stmt->fetchAll();

} catch (PDOException $e) {
    error_log($e->getMessage());
    $products = [];
}

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta
        name="description"
        content="Discover fresh groceries, fruits and vegetables at Green Mart."
    >

    <title><?php echo htmlspecialchars($pageTitle); ?></title>


    
</head>

<body>

    <!-- Navigation -->
    <header class="site-header">
        <nav class="navbar container" aria-label="Main navigation">

            <a class="logo" href="index.php">
                Green Mart<span>.</span>
            </a>

            <ul class="nav-links">
                <li><a href="index.php" aria-current="page">Home</a></li>
                <li><a href="#categories">Categories</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#about">About</a></li>
            </ul>

            <div class="nav-actions">
                <button
                    class="icon-button"
                    type="button"
                    aria-label="Search (coming soon)"
                    title="Search coming soon"
                >
                    &#128269;
                </button>

                <a
                    class="icon-button"
                    href="#products"
                    aria-label="View products"
                    title="View products"
                >
                    &#128722;
                </a>
            </div>

        </nav>
    </header>

    <main>

        <!-- Hero section -->
        <section class="hero">
            <div class="container hero-content">

                <div class="hero-text">
                    <p class="eyebrow">FRESH &amp; NATURAL</p>

                    <h1>
                        Fresh groceries,<br>
                        delivered with care.
                    </h1>

                    <p class="hero-description">
                        Discover fresh fruits, vegetables and everyday
                        essentials for your home.
                    </p>

                    <a class="btn" href="#products">
                        Explore Products
                    </a>
                </div>

                <div class="hero-image">
                    <!-- Add your grocery photo here later. -->
                    <div class="image-placeholder">
                        Your grocery image goes here
                    </div>
                </div>

            </div>
        </section>
        
<!-- Product Categories -->
<section class="content-section container" id="categories">
    <div class="section-heading">
        <p class="eyebrow">EXPLORE OUR STORE</p>
        <h2>Shop by Category</h2>
        <p>Find the everyday essentials you need.</p>
    </div>

    <div class="category-grid">
        <a class="category-card" href="#products">
            <img src="assets/images/fruits.png" alt="Fresh fruits">
            <h3>Fresh Fruits</h3>
        </a>

        <a class="category-card" href="#products">
            <img src="assets/images/vegetables.png" alt="Fresh vegetables">
            <h3>Fresh Vegetables</h3>
        </a>

        <a class="category-card" href="#products">
            <img src="assets/images/milk.png" alt="Milk and dairy products">
            <h3>Dairy Products</h3>
        </a>
    </div>
</section>


       

<section class="content-section container" id="products">

    <div class="section-heading">
        <p class="eyebrow">OUR SELECTION</p>
        <h2>Featured Products</h2>
        <p>Fresh choices for your everyday shopping.</p>
    </div>

    <div class="product-grid">

        <?php if (!empty($products)): ?>

            <?php foreach ($products as $product): ?>

                <article class="product-card">

                    <img
                        src="<?php echo htmlspecialchars($product['image'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                        alt="<?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>"
                    >

                    <div class="product-info">

                        <p class="product-category">
                            <?php echo htmlspecialchars($product['category_name'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>

                        <h3>
                            <?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>
                        </h3>

                        <p class="product-price">
                            Rs. <?php echo number_format((float) $product['price'], 2); ?>
                        </p>

                        <?php if ((int) $product['stock_quantity'] > 0): ?>

                            <button class="btn" type="button" disabled>
                                Add to Cart — Coming Soon
                            </button>

                        <?php else: ?>

                            <button class="btn" type="button" disabled>
                                Out of Stock
                            </button>

                        <?php endif; ?>

                    </div>

                </article>

            <?php endforeach; ?>

        <?php else: ?>

            <p>No products are currently available.</p>

        <?php endif; ?>

    </div>

</section>


        <section class="content-section container" id="about">
            <h2>About Green Mart</h2>
            <p>Your everyday grocery shopping destination.</p>
        </section>

    </main>

    <footer class="site-footer">
        <p>
            &copy; <?php echo date("Y"); ?> Green Mart.
            All rights reserved.
        </p>
    </footer>

</body>
</html>
