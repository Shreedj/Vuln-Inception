<?php
// Inception Inc. - Insurance Company Website
session_start();

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$allowed_pages = ['home', 'quotes', 'claims', 'about', 'contact'];

if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inception Inc. - Your Trust, Our Priority</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollToPlugin.min.js"></script>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <h1>Inception <span>Inc.</span></h1>
            </div>
            <ul class="nav-menu">
                <li><a href="?page=home" class="nav-link">Home</a></li>
                <li><a href="?page=quotes" class="nav-link">Get Quote</a></li>
                <li><a href="?page=claims" class="nav-link">File Claim</a></li>
                <li><a href="?page=about" class="nav-link">About</a></li>
                <li><a href="?page=contact" class="nav-link">Contact</a></li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <?php include("pages/{$page}.php"); ?>
    </main>

    <footer class="footer">
        <p>&copy; 2026 Inception Inc. Insurance. All rights reserved.</p>
        <p style="font-size: 0.8em; color: #999;">Your dreams, our cover. Since 2020.</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
