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
          <label class="checkbox-item">
            <input type="checkbox"> Action
          </label>
          <label class="checkbox-item">
            <input type="checkbox"> RPG
          </label>
          <label class="checkbox-item">
            <input type="checkbox"> Indie
          </label>
          <label class="checkbox-item">
            <input type="checkbox"> Strategy
          </label>
          <label class="checkbox-item">
            <input type="checkbox"> Sci-Fi
          </label>
        </div>

        <span class="filter-label">Price Range</span>
        <input type="range" min="0" max="100" value="60">
        <div class="price-values">
          <span>$0</span>
          <span>$100</span>
        </div>
      </div>

      <button class="btn btn-primary btn-full">Apply Filters</button>
    </aside>

    <!-- Main Content -->
    <main class="store-main">
      <div class="store-header">
        <h2>All Games</h2>
        <select class="sort-select">
          <option>Sort by: Popularity</option>
          <option>Sort by: Price (Low to High)</option>
          <option>Sort by: Price (High to Low)</option>
          <option>Sort by: Release Date</option>
        </select>
      </div>

      <div class="games-grid">
        <!-- Game 1 -->
        <article class="game-card">
          <img src="https://cdn.cloudflare.steamstatic.com/steam/apps/2215430/header.jpg" alt="Ghost of Tsushima cover"
            class="game-card-image ghost-cover">
          <div class="game-card-content">
            <h3 class="game-card-title">Ghost of Tsushima</h3>
            <p class="game-card-desc">Action</p>
            <div class="game-card-meta">
              <span class="game-card-price">$59.99</span>
              <a href="#" class="btn btn-primary btn-sm">Buy</a>
            </div>
          </div>
        </article>

        <!-- Game 2 -->
        <article class="game-card">
          <img src="https://cdn.cloudflare.steamstatic.com/steam/apps/1091500/header.jpg" alt="Space Explorer cover"
            class="game-card-image">
          <div class="game-card-content">
            <h3 class="game-card-title">Cyberpunk 2077</h3>
            <p class="game-card-desc">Sci-Fi</p>
            <div class="game-card-meta">
              <span class="game-card-price">$39.99</span>
              <a href="game-preview.html" class="btn btn-primary btn-sm">Buy</a>
            </div>
          </div>
        </article>

        <!-- Game 3 -->
        <article class="game-card">
          <img src="https://cdn.cloudflare.steamstatic.com/steam/apps/1151640/header.jpg" alt="Medieval Wars cover"
            class="game-card-image">
          <div class="game-card-content">
            <h3 class="game-card-title">Horizon Zero Dawn</h3>
            <p class="game-card-desc">Strategy</p>
            <div class="game-card-meta">
              <span class="game-card-price">$19.99</span>
              <a href="#" class="btn btn-primary btn-sm">Buy</a>
            </div>
          </div>
        </article>

        <!-- Game 4 -->
        <article class="game-card">
          <img src="https://cdn.cloudflare.steamstatic.com/steam/apps/1888930/header.jpg"
            alt="The Last of Us Part II cover" class="game-card-image">
          <div class="game-card-content">
            <h3 class="game-card-title">The Last of Us Part II</h3>
            <p class="game-card-desc">Adventure</p>
            <div class="game-card-meta">
              <span class="game-card-price">$69.99</span>
              <a href="#" class="btn btn-primary btn-sm">Buy</a>
            </div>
          </div>
        </article>

        <!-- Game 5 -->
        <article class="game-card">
          <img src="https://cdn.cloudflare.steamstatic.com/steam/apps/1659420/header.jpg" alt="Uncharted 4 cover"
            class="game-card-image">
          <div class="game-card-content">
            <h3 class="game-card-title">Uncharted 4</h3>
            <p class="game-card-desc">Adventure</p>
            <div class="game-card-meta">
              <span class="game-card-price">$29.99</span>
              <a href="#" class="btn btn-primary btn-sm">Buy</a>
            </div>
          </div>
        </article>

        <!-- Game 6 -->
        <article class="game-card">
          <img src="https://cdn.cloudflare.steamstatic.com/steam/apps/2208920/header.jpg"
            alt="Assassin's Creed Valhalla cover" class="game-card-image">
          <div class="game-card-content">
            <h3 class="game-card-title">AC Valhalla</h3>
            <p class="game-card-desc">Action</p>
            <div class="game-card-meta">
              <span class="game-card-price">$59.99</span>
              <a href="#" class="btn btn-primary btn-sm">Buy</a>
            </div>
          </div>
        </article>
      </div>

      <!-- Pagination -->
      <div class="pagination">
        <button class="page-btn prev">Previous</button>
        <button class="page-btn active">1</button>
        <button class="page-btn">2</button>
        <button class="page-btn">3</button>
        <button class="page-btn next">Next</button>
      </div>

    </main>
  </div>
</div>