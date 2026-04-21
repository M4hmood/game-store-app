<div class="store-container" style="padding-top: 100px; min-height: 80vh;">
    <?php if (isset($_GET['transaction']) && $_GET['transaction'] === 'completed'): ?>
        <div style="background-color: rgba(0, 255, 0, 0.1); border: 1px solid var(--neon-green); color: white; padding: 15px; margin-bottom: 20px; border-radius: 5px; text-align: center;">
            <strong>Transaction Completed!</strong> The requested software has been added to your Neural Link Library.
        </div>
    <?php endif; ?>

    <h2 class="dashboard-title" style="color: white; margin-bottom: 20px;">My Profile</h2>
    <div style="color: white; margin-bottom: 30px;">
        <p><strong>Username:</strong> <?= htmlspecialchars($_SESSION['username']) ?></p>
    </div>

    <h3 style="color: white; margin-bottom: 15px;">My Purchased Games</h3>
    <div class="games-grid">
        <?php if (empty($orders)): ?>
            <p style="color: gray;">You haven't purchased any games yet.</p>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <article class="game-card">
                    <img src="<?= htmlspecialchars($order['cover_image_path'] ?: '/assets/images/default.jpg') ?>" alt="Game cover" class="game-card-image">
                    <div class="game-card-content">
                        <h3 class="game-card-title"><?= htmlspecialchars($order['title']) ?></h3>
                        <p class="game-card-desc">Purchased on: <?= substr($order['created_at'], 0, 10) ?></p>
                        <div class="game-card-meta">
                            <span class="game-card-price">Paid: $<?= htmlspecialchars($order['price_at_purchase']) ?></span>
                            <!-- Link to download or play could go here -->
                            <a href="#" class="btn btn-secondary btn-sm">Play</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
