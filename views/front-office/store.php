<!-- Store Layout -->
<div class="store-container">
  <div class="store-layout">

    <!-- Sidebar Filters -->
    <aside class="store-sidebar">
      <div class="store-search">
        <input type="text" class="form-input" placeholder="Search games...">
      </div>

      <div class="filter-group">
        <div class="filter-header">
          <h3 class="filter-title">Filters</h3>
        </div>

        <span class="filter-label">Genre</span>
        <div class="checkbox-list">
          <label class="checkbox-item"><input type="checkbox"> Action</label>
          <label class="checkbox-item"><input type="checkbox"> RPG</label>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="store-main">
      <div class="store-header">
        <h2>All Games</h2>
      </div>

      <div class="games-grid">
        <?php if (!empty($games)): ?>
            <?php foreach ($games as $game): ?>
              <a href="/game?id=<?= $game['id'] ?>" style="text-decoration: none; color: inherit;">
              <article class="game-card">
                <img src="<?= htmlspecialchars($game['cover_image_path'] ?: 'https://placehold.co/600x400/101015/00f5ff?text=Game') ?>" 
                     alt="<?= htmlspecialchars($game['title']) ?> cover" 
                     class="game-card-image"
                     onerror="this.src='https://placehold.co/600x400/101015/00f5ff?text=<?= urlencode($game['title']) ?>'">
                <div class="game-card-content">
                  <h3 class="game-card-title"><?= htmlspecialchars($game['title']) ?></h3>
                  <p class="game-card-desc"><?= htmlspecialchars($game['description'] ?? '') ?></p>
                  <div class="game-card-meta">
                    <span class="game-card-price">$<?= htmlspecialchars($game['price']) ?></span>
                    <span class="tag" style="font-size: 0.7rem;"><?= htmlspecialchars($game['category_name'] ?? 'Uncategorized') ?></span>
                  </div>
                </div>
              </article>
              </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: white;">No games available in the store yet.</p>
        <?php endif; ?>
      </div>

    </main>
  </div>
</div>