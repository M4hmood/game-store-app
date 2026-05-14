<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Adjusted paths to start with / so they work everywhere -->
    <title>NEXUS//VAULT &mdash; Game Store</title>
    <meta name="description"
        content="Discover, collect, and play the best PC games. NEXUS//VAULT is your modern game library.">
    <link rel="icon" type="image/png" href="/assets/icons/controller.png">
    <link rel="stylesheet" href="/assets/css/styles.css">
    
    <!-- Client-Side JavaScript Logic -->
    <script src="/assets/js/validation.js" defer></script>
    <script src="/assets/js/store.js" defer></script>
</head>

<body>
    <!-- Navigation -->
    <nav class="nav">
        <div class="nav-container">
            <a href="/" class="nav-logo">NEXUS//VAULT</a>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="/store">Store</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/profile">My Profile</a></li>
                <?php endif; ?>
                <li><a href="/contact">Contact Us</a></li>
            </ul>
            <div class="nav-auth">
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/cart" class="btn btn-secondary btn-sm" style="margin-right:auto;">🛒 Cart (<?= count($_SESSION['cart'] ?? []) ?>)</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span style="color: white; margin-right: 15px;">User: <?= htmlspecialchars($_SESSION['username']) ?></span>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="/admin" class="btn btn-primary" style="margin-right:10px;">Admin Panel</a>
                    <?php endif; ?>
                    <a href="/logout" class="btn btn-secondary">Logout</a>
                <?php else: ?>
                    <a href="/signin" class="btn btn-secondary">Sign In</a>
                    <a href="/signup" class="btn btn-primary">Join Now</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>