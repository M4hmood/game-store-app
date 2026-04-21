<?php
// $game is passed from GameController::preview()
// $isOwned is passed from GameController::preview()
$title = htmlspecialchars($game['title']);
$description = htmlspecialchars($game['description'] ?? '');
$price = htmlspecialchars($game['price']);
$category = htmlspecialchars($game['category_name'] ?? 'Uncategorized');
$coverImage = htmlspecialchars($game['cover_image_path'] ?: '/assets/images/games/placeholder.jpg');
$gameId = (int)$game['id'];
?>

<style>
  .game-detail-hero {
    position: relative;
    height: 70vh;
    min-height: 500px;
    margin-top: 80px;
    display: flex;
    align-items: flex-end;
    background: linear-gradient(to bottom, rgba(13, 13, 20, 0) 0%, var(--bg-primary) 100%);
  }

  .game-detail-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url('<?= $coverImage ?>');
    background-size: cover;
    background-position: center top;
    opacity: 0.25;
    z-index: 0;
    filter: blur(2px);
  }

  .hero-info {
    max-width: 1400px;
    margin: 0 auto;
    padding: var(--space-xl) var(--space-lg);
    width: 100%;
    position: relative;
    z-index: 1;
  }

  .game-detail-title {
    font-size: clamp(2.5rem, 6vw, 4.5rem);
    margin-bottom: var(--space-md);
    line-height: 1.1;
  }

  .game-meta-bar {
    display: flex;
    gap: var(--space-lg);
    flex-wrap: wrap;
    align-items: center;
    margin-top: var(--space-lg);
  }

  .meta-item {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
    font-size: 0.9rem;
    color: var(--text-secondary);
  }

  .meta-icon {
    color: var(--neon-cyan);
  }

  .detail-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: var(--space-xl) var(--space-lg);
    display: grid;
    grid-template-columns: 1fr 420px;
    gap: var(--space-xl);
    align-items: start;
  }

  .detail-main {
    display: flex;
    flex-direction: column;
    gap: var(--space-xl);
  }

  .detail-card {
    background: var(--bg-card);
    border: 1px solid rgba(0, 245, 255, 0.1);
    border-radius: var(--radius-lg);
    padding: var(--space-xl);
    position: relative;
    overflow: hidden;
  }

  .detail-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--gradient-cyber);
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .detail-card:hover::before {
    opacity: 1;
  }

  .card-title {
    font-size: 1.8rem;
    margin-bottom: var(--space-lg);
  }

  .card-text {
    color: var(--text-secondary);
    line-height: 1.8;
    margin-bottom: var(--space-md);
  }

  .cover-showcase {
    border-radius: var(--radius-md);
    overflow: hidden;
    border: 1px solid rgba(0, 245, 255, 0.2);
    transition: all 0.4s ease;
    position: relative;
  }

  .cover-showcase:hover {
    transform: translateY(-4px);
    box-shadow: var(--glow-cyan);
    border-color: var(--neon-cyan);
  }

  .cover-showcase img {
    width: 100%;
    display: block;
  }

  .purchase-sidebar {
    position: sticky;
    top: 100px;
  }

  .buy-box {
    background: var(--bg-card);
    border: 2px solid rgba(0, 245, 255, 0.3);
    border-radius: var(--radius-lg);
    padding: var(--space-xl);
    box-shadow: 0 0 40px rgba(0, 245, 255, 0.15);
    position: relative;
    overflow: hidden;
  }

  .buy-box::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(0, 245, 255, 0.1) 0%, transparent 50%);
    animation: pulse 4s ease-in-out infinite;
  }

  @keyframes pulse {
    0%,
    100% {
      opacity: 0.5;
      transform: scale(1);
    }
    50% {
      opacity: 0.8;
      transform: scale(1.1);
    }
  }

  .buy-box>* {
    position: relative;
    z-index: 1;
  }

  .pricing {
    text-align: center;
    padding: var(--space-lg) 0;
    border-bottom: 1px solid rgba(0, 245, 255, 0.15);
    margin-bottom: var(--space-xl);
  }

  .price-current {
    font-size: 3.5rem;
    font-weight: 900;
    background: var(--gradient-cyber);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-family: var(--font-mono);
    display: block;
    line-height: 1;
    margin: var(--space-md) 0;
    text-shadow: 0 0 40px rgba(0, 245, 255, 0.4);
  }

  .action-buttons {
    display: flex;
    flex-direction: column;
    gap: var(--space-md);
    margin-bottom: var(--space-xl);
  }

  .game-info-list {
    list-style: none;
  }

  .game-info-list li {
    display: flex;
    justify-content: space-between;
    padding: var(--space-md) 0;
    border-bottom: 1px solid rgba(0, 245, 255, 0.05);
    font-size: 0.9rem;
  }

  .info-key {
    color: var(--text-muted);
    font-family: var(--font-display);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .info-val {
    color: var(--text-primary);
    font-weight: 600;
    text-align: right;
  }

  .rating-box {
    background: rgba(0, 245, 255, 0.05);
    border: 1px solid rgba(0, 245, 255, 0.2);
    border-radius: var(--radius-md);
    padding: var(--space-lg);
    display: flex;
    align-items: center;
    gap: var(--space-lg);
  }

  .rating-score {
    font-size: 3.5rem;
    font-weight: 900;
    font-family: var(--font-mono);
    background: var(--gradient-electric);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
  }

  .rating-info {
    flex: 1;
  }

  .rating-stars {
    color: var(--neon-yellow);
    font-size: 1.3rem;
    margin-bottom: var(--space-sm);
    text-shadow: 0 0 10px rgba(249, 240, 2, 0.5);
  }

  .rating-text {
    color: var(--text-secondary);
    font-size: 0.85rem;
    font-family: var(--font-display);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .owned-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: rgba(0, 245, 255, 0.1);
    border: 1px solid rgba(0, 245, 255, 0.3);
    border-radius: var(--radius-md);
    color: var(--neon-cyan);
    font-family: var(--font-display);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    width: 100%;
    justify-content: center;
  }

  @media (max-width: 1200px) {
    .detail-container {
      grid-template-columns: 1fr;
    }

    .purchase-sidebar {
      position: static;
    }
  }

  @media (max-width: 768px) {
    .game-meta-bar {
      flex-direction: column;
      align-items: flex-start;
      gap: var(--space-sm);
    }
  }
</style>

<!-- Hero -->
<div class="game-detail-hero">
  <div class="hero-info">
    <h1 class="game-detail-title"><?= $title ?></h1>
    <p class="hero-subtitle"><?= $description ?></p>
    <div class="game-meta-bar">
      <div class="meta-item">
        <span class="meta-icon">🏷️</span>
        <span><?= $category ?></span>
      </div>
      <div class="meta-item">
        <span class="meta-icon">🎮</span>
        <span>Single-player</span>
      </div>
      <div class="meta-item">
        <span class="meta-icon">💰</span>
        <span>$<?= $price ?></span>
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="detail-container">
  <div class="detail-main">
    <!-- About -->
    <div class="detail-card">
      <h2 class="card-title">About This Game</h2>
      <p class="card-text">
        <?= $description ?>
      </p>
      <div class="tags">
        <span class="tag"><?= $category ?></span>
      </div>
    </div>

    <!-- Game Cover -->
    <div class="detail-card">
      <h2 class="card-title">Game Cover</h2>
      <div class="cover-showcase">
        <img src="<?= $coverImage ?>" alt="<?= $title ?> cover"
          onerror="this.src='https://placehold.co/600x400/101015/00f5ff?text=<?= urlencode($game['title']) ?>'">
      </div>
    </div>

    <!-- Reviews -->
    <div class="detail-card">
      <h2 class="card-title">Community Rating</h2>
      <div class="rating-box">
        <div class="rating-score">9.0</div>
        <div class="rating-info">
          <div class="rating-stars">★★★★★</div>
          <div class="rating-text">Very Positive</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Sidebar -->
  <aside class="purchase-sidebar">
    <div class="buy-box">
      <div class="pricing">
        <div class="price-current">$<?= $price ?></div>
      </div>

      <div class="action-buttons">
        <?php if ($isOwned): ?>
          <div class="owned-badge">✓ Already in Library</div>
        <?php else: ?>
          <form action="/cart/add" method="POST" style="margin:0;">
            <input type="hidden" name="game_id" value="<?= $gameId ?>">
            <button type="submit" class="btn btn-primary btn-full btn-lg">Add to Cart</button>
          </form>
        <?php endif; ?>
      </div>

      <ul class="game-info-list">
        <li>
          <span class="info-key">Genre</span>
          <span class="info-val"><?= $category ?></span>
        </li>
        <li>
          <span class="info-key">Platform</span>
          <span class="info-val">Windows</span>
        </li>
        <li>
          <span class="info-key">Game ID</span>
          <span class="info-val">#<?= $gameId ?></span>
        </li>
      </ul>
    </div>
  </aside>
</div>