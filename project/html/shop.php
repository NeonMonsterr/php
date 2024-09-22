<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../html/login.php?loginError=You must log in first.");
    exit();
}

require "../backend/connection.php";

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : ''; 
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

$sql = "SELECT * FROM products WHERE 1=1";
$params = [];

if (!empty($searchTerm)) {
    $sql .= " AND product_name LIKE :searchTerm";
    $params['searchTerm'] = '%' . $searchTerm . '%'; 
}

if (!empty($selectedCategory)) {
    $sql .= " AND category_id = :category_id";
    $params['category_id'] = $selectedCategory;
}

$result = $db->conn->prepare($sql);
$result->execute($params);
$products = $result->fetchAll(PDO::FETCH_ASSOC); 

$result2 = $db->conn->prepare("SELECT * FROM categories");
$result2->execute();
$categories = $result2->fetchAll(PDO::FETCH_ASSOC);

$result = $db->conn->prepare("SELECT SUM(quantity) AS total_items FROM order_items oi JOIN orders o ON oi.order_id = o.order_id WHERE o.user_id = :userId AND o.status = 'pending'");
$result->execute(['userId' => $_SESSION['id']]);
$cartCount = $result->fetch(PDO::FETCH_ASSOC)['total_items'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - VcpRagon</title>
    <link rel="stylesheet" href="../css/home.css"> <!-- Your custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
</head>

<body>
    <!-- Navigation Bar -->
    <header>
        <nav class="navbar">
            <div class="logo">VcpRagon</div>
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </div>
            <div class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count"><?php echo htmlspecialchars($cartCount); ?></span>
                <a href="cart_checkout.php" class="btn btn-warning">Go to Cart</a>
                </div>
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </nav>
    </header>

    <!-- Shop Section -->
    <section id="shop" class="shop-section py-5">
        <div class="container">
            <h2 class="text-center mb-4">Our Products</h2>

            <!-- Search and Category Selection -->
            <div class="mb-4 text-center">
                <form class="form-inline justify-content-center" action="shop.php" method="GET">
                    <input class="form-control mr-2" type="search" placeholder="Search products..." aria-label="Search" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>"> <!-- Persistent search term -->

                    <select class="form-control mr-2" name="category">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['category_id']); ?>">
                                <?php echo htmlspecialchars($category['category_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
            </div>

            <div class="row">
                <?php if (empty($products)): ?>
                    <p class="text-center">No products found.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" class="card-img-top" alt="Product Image">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                    <p class="price">$<?php echo htmlspecialchars($product['price']); ?></p>
                                    <a href="add_to_cart.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>" class="btn btn-primary">Add to Cart</a>
                                    </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 MyWebsite. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>