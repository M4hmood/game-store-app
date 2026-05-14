<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Games &mdash; NEXUS//VAULT Admin</title>
    <link rel="icon" type="image/png" href="/assets/icons/controller.png">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <script src="/assets/js/validation.js" defer></script>
    <style>
      #add-game-modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.65); z-index: 2000; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
      .modal-content { background: var(--bg-card); padding: 28px; border-radius: var(--radius-lg); border: 1px solid var(--border); max-width: 500px; width: calc(100% - 32px); position: relative; box-shadow: var(--shadow-lg); }
      .close-btn { position: absolute; top: 12px; right: 12px; background: transparent; border: none; color: var(--text-secondary); cursor: pointer; font-size: 1.5rem; line-height: 1; transition: color 0.15s; }
      .close-btn:hover { color: var(--text-primary); }
      .card-add { display: flex; flex-direction: column; align-items: center; justify-content: center; border: 2px dashed var(--border); cursor: pointer; min-height: 250px; background: var(--bg-card); transition: all 0.15s; }
      .card-add:hover { background: var(--bg-hover); border-color: var(--accent); }
      .add-icon { font-size: 3rem; color: var(--accent); font-weight: 300; }
      .add-text { color: var(--accent); font-family: var(--font-display); font-size: 1rem; font-weight: 500; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="nav">
        <div class="nav-container">
            <a href="/" class="nav-logo">NEXUS//VAULT</a>
            <ul class="nav-links">
                <li><a href="/store">Store Frontend</a></li>
            </ul>
            <div class="nav-auth">
                <span class="admin-badge">Admin</span>
                <a href="/logout" class="btn btn-secondary">Sign out</a>
            </div>
        </div>
    </nav>

    <!-- Dashboard -->
    <main class="dashboard">
        <div class="dashboard-grid">
            <!-- Sidebar -->
            <aside class="dashboard-sidebar">
        <ul class="sidebar-menu">
          <li><a href="/admin">📊 Overview</a></li>
          <li><a href="/admin/games/add" class="active">🎮 Games</a></li>
          <li><a href="/admin/users">👥 Users</a></li>
          <li><a href="/admin/revenue">💰 Revenue</a></li>
          <li><a href="/admin/settings">⚙️ Settings</a></li>
        </ul>
            </aside>

            <!-- Main Content -->
            <div class="dashboard-main">
                <h1 class="dashboard-title">Games</h1>

                <!-- Games Grid Section -->
                <h3 class="chart-title" style="margin-top: 1rem; margin-bottom: 1.5rem;">Catalog</h3>

                <div class="games-grid">
                    <!-- 1. Add New Game Card -->
                    <article class="game-card card-add" onclick="document.getElementById('add-game-modal').style.display='flex'">
                        <div class="add-icon">+</div>
                        <p class="add-text">Add New Game</p>
                    </article>

                    <!-- Existing Games Dynamically Rendered -->
                    <?php if(!empty($games)): ?>
                        <?php foreach($games as $game): ?>
                        <article class="game-card">
                            <img src="<?= htmlspecialchars($game['cover_image_path'] ?: 'https://placehold.co/600x400/161b22/8b949e?text=Game') ?>"
                                alt="<?= htmlspecialchars($game['title']) ?>" class="game-card-image"
                                onerror="this.src='https://placehold.co/600x400/161b22/8b949e?text=<?= urlencode($game['title']) ?>'">
                            <div class="game-card-content">
                                <h3 class="game-card-title"><?= htmlspecialchars($game['title']) ?></h3>
                                <p class="game-card-played">Status: Published</p>
                                <div class="game-card-meta" style="display:block;">
                                    <form method="POST" action="/admin/games/delete" style="width:100%; display:flex; flex-direction:column; gap:6px;">
                                        <button type="button" class="btn btn-sm btn-secondary btn-full" onclick="openEditModal(<?= $game['id'] ?>, '<?= htmlspecialchars(addslashes($game['title'])) ?>', '<?= $game['price'] ?>', <?= $game['category_id'] ?>)">Edit</button>
                                        <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger btn-full">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Add Game Modal -->
    <div id="add-game-modal">
        <div class="modal-content">
            <button class="close-btn" onclick="document.getElementById('add-game-modal').style.display='none'">&times;</button>
            <h2 style="color: var(--text-primary); margin-bottom: 20px; font-family: var(--font-display); font-size: 1.25rem; font-weight: 700;">Add new game</h2>

            <form action="/admin/games/add" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-input">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Price ($)</label>
                    <input type="number" step="0.01" name="price" class="form-input" required value="0.00">
                </div>

                <div class="form-group">
                    <label class="form-label">Cover image</label>
                    <input type="file" name="cover_image" class="form-input" accept="image/*" required>
                </div>

                <button type="submit" class="btn btn-primary btn-full" style="margin-top: 8px;">Add game</button>
            </form>
        </div>
    </div>

    <!-- Edit Game Modal -->
    <div id="edit-game-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.65); z-index: 2000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <div class="modal-content">
            <button class="close-btn" onclick="document.getElementById('edit-game-modal').style.display='none'">&times;</button>
            <h2 style="color: var(--text-primary); margin-bottom: 20px; font-family: var(--font-display); font-size: 1.25rem; font-weight: 700;">Edit game</h2>

            <form action="/admin/games/edit" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="game_id" id="edit-game-id">

                <div class="form-group">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" id="edit-game-title" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select name="category_id" id="edit-game-category" class="form-input">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Price ($)</label>
                    <input type="number" step="0.01" name="price" id="edit-game-price" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Cover image (optional)</label>
                    <input type="file" name="cover_image" class="form-input" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary btn-full" style="margin-top: 8px;">Save changes</button>
            </form>
        </div>
    </div>

    <script>
    function openEditModal(id, title, price, category_id) {
        document.getElementById('edit-game-id').value = id;
        document.getElementById('edit-game-title').value = title;
        document.getElementById('edit-game-price').value = price;
        document.getElementById('edit-game-category').value = category_id;
        document.getElementById('edit-game-modal').style.display = 'flex';
    }
    </script>
</body>
</html>