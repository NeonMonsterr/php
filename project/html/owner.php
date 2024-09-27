<?php
require "../backend/connection.php";
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != "owner") {
    header("Location: ../html/login.php?loginError=You must log in first.");
    exit();
}

// Fetch products and users for display
$productStmt = $db->conn->prepare("SELECT * FROM products");
$productStmt->execute();
$products = $productStmt->fetchAll(PDO::FETCH_ASSOC);

$userStmt = $db->conn->prepare("SELECT *, ban_reason, ban_untill FROM users");
$userStmt->execute();
$users = $userStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page - VcpRagon</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link rel="stylesheet" href="../css/home.css">
</head>

<body>
    <header class="bg-dark text-white p-3">
        <div class="container">
            <h1 class="text-center">Owner Dashboard</h1>
        </div>
    </header>

    <div class="container mt-4">
        <h2>Manage Products</h2>
        <div class="row">

            <?php if (empty($products)): ?>
                <p class="text-center">No products found.</p>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <?php
                    $stmt = $db->conn->prepare("SELECT category_name FROM categories c JOIN products p ON c.category_id = p.category_id AND p.category_id = :categoryid");
                    $stmt->execute([':categoryid' => $product['category_id']]);
                    $categoryName = $stmt->fetchColumn();
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" class="card-img-top" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                <p class="price">$<?php echo htmlspecialchars($product['price']); ?></p>
                                <button class="btn btn-info" data-toggle="modal" data-target="#productModal<?php echo $product['product_id']; ?>">View Details</button>
                                <form method="POST" action="owner_functions.php" onsubmit="return confirm('Are you sure you want to delete this product?');" class="mt-2">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details Modal -->
                    <div class="modal fade" id="productModal<?php echo $product['product_id']; ?>" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="productModalLabel"><?php echo htmlspecialchars($product['product_name']); ?> Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
                                    <p><strong>Price:</strong> $<?php echo htmlspecialchars($product['price']); ?></p>
                                    <p><strong>Category:</strong> <?php echo htmlspecialchars($categoryName); ?></p>
                                    <p><strong>Created at:</strong> <?php echo date('F j, Y, g:i A', strtotime($product['created_at'])); ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <h2 class="mt-5">Manage Users</h2>
        <div class="row">
            <?php foreach ($users as $user): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">User Name: <?php echo htmlspecialchars($user['username']); ?></h5>
                            <p class="card-text">Email: <?php echo htmlspecialchars($user['email']); ?></p>
                            <p class="card-text">Banned: <?php echo htmlspecialchars($user['is_banned'] ? "Yes" : "No"); ?></p>

                            <?php if ($user['is_banned']): ?>
                                <p class="card-text"><strong>Ban Reason:</strong> <?php echo htmlspecialchars($user['ban_reason']); ?></p>
                                <p class="card-text"><strong>Ban Until:</strong> <?php echo date('F j, Y, g:i A', strtotime($user['ban_untill'])); ?></p>
                            <?php endif; ?>

                            <div class="d-flex justify-content-between">
                                <button class="btn btn-info btn-rounded" data-toggle="modal" data-target="#userModal<?php echo $user['user_id']; ?>">View Details</button>
                                <?php if ($user['role'] != "owner"): ?>
                                    <a href="edit_user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-warning btn-rounded">Edit</a>
                                    <form method="POST" action="owner_functions.php" onsubmit="return confirm('Are you sure you want to delete this user?');" class="mt-2">
                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
                                        <button type="submit" class="btn btn-danger btn-rounded">Delete</button>
                                    </form>
                                    <button class="btn btn-warning" data-toggle="modal" data-target="#banModal<?php echo $user['user_id']; ?>">Ban</button>
                                    <?php if ($user['is_banned']): ?>
                                        <form method="POST" action="../backend/ban_user.php" class="mt-2">
                                            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                            <input type="hidden" name="action" value="unban">
                                            <button type="submit" class="btn btn-success">Unban</button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <form action="view_orders.php" method="post">
                                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                        <button type="submit" class="btn btn-primary">View Orders</button>
                                    </form>
                            </div>
                        </div>
                    </div>

                    <!-- User Details Modal -->
                    <div class="modal fade" id="userModal<?php echo $user['user_id']; ?>" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="userModalLabel"><?php echo htmlspecialchars($user['username']); ?> Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                                    <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
                                    <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phone_number']); ?></p>
                                    <p><strong>Join Date:</strong> <?php echo date('F j, Y, g:i A', strtotime($user['created_at'])); ?></p>
                                    <p><strong>Location:</strong> <?php echo htmlspecialchars($user['city']) . ', ' . htmlspecialchars($user['state']) . ', ' . htmlspecialchars($user['country']); ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                     <!-- Ban Modal -->
    <div class="modal fade" id="banModal<?php echo $user['user_id']; ?>" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="banModalLabel">Ban User: <?php echo htmlspecialchars($user['username']); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="../backend/ban_user.php">
                    <div class="modal-body">
                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

                        <div class="form-group">
                            <label for="ban_duration">Ban Duration</label>
                            <select class="form-control" id="ban_duration" name="ban_duration">
                                <option value="1_day">1 Day</option>
                                <option value="1_week">1 Week</option>
                                <option value="1_month">1 Month</option>
                                <option value="1_year">1 Year</option>
                                <option value="permanent">Permanent</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ban_reason">Ban Reason</label>
                            <textarea class="form-control" id="ban_reason" name="ban_reason" rows="3" placeholder="Enter the reason for banning"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Ban User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="bg-dark text-white p-3 mt-4">
        <div class="container text-center">
            <p>&copy; <?php echo date("Y"); ?> VcpRagon. All Rights Reserved.</p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>