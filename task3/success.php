<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5 text-center">
        <h1>Registration Successful</h1>
        <p>Your data has been saved successfully.</p>

        <?php
        if (isset($_GET['image'])) {
            $imagePath = htmlspecialchars($_GET['image']);
            echo "<img src='$imagePath' class='img-fluid mt-3' alt='Uploaded Image'>";
        }
        ?>

        <a href="register.php" class="btn btn-primary mt-4">Back to Register</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
