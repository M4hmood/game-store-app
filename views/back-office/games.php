<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Games - NEXUS VAULT</title>
    <link rel="icon" type="image/png" href="/assets/icons/controller.png">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <script src="/assets/js/validation.js" defer></script>
    <style>
      .admin-input { width: 100%; padding: 10px; margin-bottom: 15px; background: #000; color: #fff; border: 1px solid rgba(0, 245, 255, 0.3); border-radius: 4px; font-family: var(--font-body); }
      #add-game-modal { display: none; position: fixed; inset: 0; background: rgba(10,10,15,0.9); z-index: 2000; align-items: center; justify-content: center; backdrop-filter: blur(5px); }
      .modal-content { background: var(--bg-secondary); padding: 30px; border-radius: 8px; border: 1px solid var(--neon-cyan); max-width: 500px; width: 100%; position: relative; box-shadow: var(--glow-cyan); }
      .close-btn { position: absolute; top: 15px; right: 15px; background: transparent; border: none; color: white; cursor: pointer; font-size: 1.5rem; transition: color 0.3s ease; }
      .close-btn:hover { color: var(--neon-cyan); }
      .card-add { display: flex; flex-direction: column; align-items: center; justify-content: center; border: 2px dashed var(--neon-cyan); cursor: pointer; min-height: 250px; background: rgba(0,245,255,0.05); }
      .card-add:hover { background: rgba(0,245,255,0.1); transform: scale(1.02); }
      .add-icon { font-size: 4rem; color: var(--neon-cyan); }
      .add-text { color: var(--neon-cyan); font-family: var(--font-display); font-size: 1.2rem; text-transform: uppercase; letter-spacing: 0.1em; }
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
                <span class="admin-badge">ADMIN MODE</span>
                <a href="/logout" class="btn btn-secondary">Sign Out</a>
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
                <h1 class="dashboard-title">Game Management</h1>

                <!-- Games Grid Section -->
                <h3 class="chart-title" style="margin-top: 1rem; margin-bottom: 2rem;">Full Catalog</h3>

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
                            <img src="<?= htmlspecialchars($game['cover_image_path'] ?: 'https://placehold.co/600x400/101015/00f5ff?text=Game') ?>"
                                alt="<?= htmlspecialchars($game['title']) ?>" class="game-card-image"
                                onerror="this.src='https://placehold.co/600x400/101015/00f5ff?text=<?= urlencode($game['title']) ?>'">
                            <div class="game-card-content">
                                <h3 class="game-card-title"><?= htmlspecialchars($game['title']) ?></h3>
                                <p class="game-card-played">Status: Published</p>
                                <div class="game-card-meta">
                                    <form method="POST" action="/admin/games/delete" style="width:100%;">
                                        <button type="button" class="btn btn-sm btn-primary btn-full" style="margin-bottom:5px;" onclick="openEditModal(<?= $game['id'] ?>, '<?= htmlspecialchars(addslashes($game['title'])) ?>', '<?= $game['price'] ?>', <?= $game['category_id'] ?>)">Edit Game</button>
                                        <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-full" style="background:#ff4444; color:white; border:none; margin-top:5px;">Delete</button>
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

    <!-- JS Controlled Modal for Adding Game Forms -->
    <div id="add-game-modal">
        <div class="modal-content">
            <button class="close-btn" onclick="document.getElementById('add-game-modal').style.display='none'">&times;</button>
            <h2 style="color:var(--neon-cyan); margin-bottom: 20px; font-family: var(--font-display);">Register Game Payload</h2>
            
            <form action="/admin/games/add" method="POST" enctype="multipart/form-data">
                <div>
                    <label style="color:var(--text-secondary); font-size:0.8rem; display:block; margin-bottom:5px;">Game Title</label>
                    <input type="text" name="title" class="admin-input" required>
                </div>
                
                <div>
                    <label style="color:var(--text-secondary); font-size:0.8rem; display:block; margin-bottom:5px;">Category</label>
                    <select name="category_id" class="admin-input">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label style="color:var(--text-secondary); font-size:0.8rem; display:block; margin-bottom:5px;">Price (Credits)</label>
                    <input type="number" step="0.01" name="price" class="admin-input" required value="0.00">
                </div>
                
                <div>
                    <label style="color:var(--text-secondary); font-size:0.8rem; display:block; margin-bottom:5px;">Cover Image (.jpg / .png)</label>
                    <input type="file" name="cover_image" class="admin-input" accept="image/*" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-full" style="margin-top:10px;">Upload to Network</button>
            </form>
        </div>
    </div>

    <!-- JS Controlled Modal for Editing Games -->
    <div id="edit-game-modal" style="display: none; position: fixed; inset: 0; background: rgba(10,10,15,0.9); z-index: 2000; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
        <div class="modal-content">
            <button class="close-btn" onclick="document.getElementById('edit-game-modal').style.display='none'">&times;</button>
            <h2 style="color:var(--neon-magenta); margin-bottom: 20px; font-family: var(--font-display);">Update Game Payload</h2>
            
            <form action="/admin/games/edit" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="game_id" id="edit-game-id">
                
                <div>
                    <label style="color:var(--text-secondary); font-size:0.8rem; display:block; margin-bottom:5px;">Game Title</label>
                    <input type="text" name="title" id="edit-game-title" class="admin-input" required>
                </div>
                
                <div>
                    <label style="color:var(--text-secondary); font-size:0.8rem; display:block; margin-bottom:5px;">Category</label>
                    <select name="category_id" id="edit-game-category" class="admin-input">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label style="color:var(--text-secondary); font-size:0.8rem; display:block; margin-bottom:5px;">Price (Credits)</label>
                    <input type="number" step="0.01" name="price" id="edit-game-price" class="admin-input" required>
                </div>
                
                <div>
                    <label style="color:var(--text-secondary); font-size:0.8rem; display:block; margin-bottom:5px;">Cover Image (Optional)</label>
                    <input type="file" name="cover_image" class="admin-input" accept="image/*">
                </div>
                
                <button type="submit" class="btn btn-primary btn-full" style="margin-top:10px;">Save Changes</button>
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