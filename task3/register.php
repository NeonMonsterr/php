<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Register</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data" class="border p-4 shadow-sm rounded">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="image">Upload Image:</label>
                <input type="file" name="image" accept="image/*" class="form-control-file" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </form>

        <?php
        if (isset($_GET['error'])) {
            echo "<div class='alert alert-danger mt-3'>" . htmlspecialchars($_GET['error']) . "</div>";
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
