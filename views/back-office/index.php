<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - NEXUS VAULT</title>
  <link rel="icon" type="image/png" href="/assets/icons/controller.png">
  <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
  <!-- Navigation -->
  <nav class="nav">
    <div class="nav-container">
      <a href="/" class="nav-logo">NEXUS//VAULT</a>
      <ul class="nav-links">
        <li><a href="/">Store Frontend</a></li>
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
          <li><a href="/admin" class="active">📊 Overview</a></li>
          <li><a href="/admin/games/add">🎮 Games</a></li>
          <li><a href="/admin/users">👥 Users</a></li>
          <li><a href="/admin/revenue">💰 Revenue</a></li>
          <li><a href="/admin/settings">⚙️ Settings</a></li>
        </ul>
      </aside>

      <!-- Main Content -->
      <div class="dashboard-main">
        <h1 class="dashboard-title">Control Center</h1>

        <!-- Stats Cards -->
        <div class="stats-grid" style="margin-bottom: 30px;">
          <div class="stat-card">
            <span class="stat-card-icon">💰</span>
            <span class="stat-card-value">$<?= number_format($totalRevenue, 2) ?></span>
            <span class="stat-card-label">Total Revenue</span>
          </div>
          <div class="stat-card accent-pink">
            <span class="stat-card-icon">👥</span>
            <span class="stat-card-value"><?= count($users) ?></span>
            <span class="stat-card-label">Registered Users</span>
          </div>
          <div class="stat-card accent-yellow">
            <span class="stat-card-icon">🎮</span>
            <span class="stat-card-value"><?= count($games) ?></span>
            <span class="stat-card-label">Games Available</span>
          </div>
          <div class="stat-card accent-green">
            <span class="stat-card-icon">📦</span>
            <span class="stat-card-value"><?= count($orders) ?></span>
            <span class="stat-card-label">Total Orders</span>
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <!-- Recent Users Table -->
            <div class="chart-container">
            <h3 class="chart-title">Users List</h3>
            <table class="data-table">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td style="font-size: 0.8rem;"><?= htmlspecialchars($user['email']) ?></td>
                    <td><span class="status-badge <?= $user['role'] === 'admin' ? 'active' : '' ?>"><?= htmlspecialchars($user['role']) ?></span></td>
                    <td style="display:flex; gap: 5px;">
                        <button class="btn btn-sm" style="background:#00d2ff; color:black; border:none; padding: 5px 10px; cursor: pointer;" onclick="openEditUserModal(<?= $user['id'] ?>, '<?= htmlspecialchars(addslashes($user['username'])) ?>', '<?= htmlspecialchars(addslashes($user['email'])) ?>', '<?= htmlspecialchars(addslashes($user['role'] ?? 'client')) ?>')">Edit</button>
                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                        <form method="POST" action="/admin/users/delete" style="margin: 0;">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button class="btn btn-sm" style="background: red; color: white; border:none; padding: 5px 10px; cursor: pointer;" title="Ban">Del</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>

            <!-- Games Management Table -->
            <div class="chart-container">
            <h3 class="chart-title">Games Inventory</h3>
            <table class="data-table">
                <thead>
                <tr>
                    <th>Game</th>
                    <th>Genre</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($games as $game): ?>
                <tr>
                    <td class="text-primary"><?= htmlspecialchars($game['title']) ?></td>
                    <td><?= htmlspecialchars($game['category_name'] ?? 'None') ?></td>
                    <td>$<?= htmlspecialchars($game['price']) ?></td>
                    <td>
                        <form method="POST" action="/admin/games/delete" style="margin: 0;">
                            <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                            <button class="btn btn-sm" style="background: red; color: white; border:none; padding: 5px 10px; cursor: pointer;">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>

      </div>
    </div>
  </main>

  <div id="edit-user-modal" style="display: none; position: fixed; inset: 0; background: rgba(10,10,15,0.9); z-index: 2000; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
      <div class="modal-content" style="background: var(--bg-secondary); padding: 30px; border-radius: 8px; border: 1px solid var(--neon-cyan); max-width: 500px; width: 100%; position: relative; box-shadow: var(--glow-cyan);">
          <button class="close-btn" style="position: absolute; top: 15px; right: 15px; background: transparent; border: none; color: white; cursor: pointer; font-size: 1.5rem;" onclick="document.getElementById('edit-user-modal').style.display='none'">&times;</button>
          <h2 style="color:var(--neon-cyan); margin-bottom: 20px; font-family: var(--font-display);">Modify User Details</h2>
          
          <form action="/admin/users/edit" method="POST">
              <input type="hidden" name="user_id" id="edit-user-id">
              
              <div>
                  <label style="color:var(--text-secondary); display:block; margin-bottom:5px;">Username</label>
                  <input type="text" name="username" id="edit-user-username" class="admin-input" style="width: 100%; padding: 10px; margin-bottom: 15px; background: #000; color: #fff; border: 1px solid rgba(0, 245, 255, 0.3); border-radius: 4px;" required>
              </div>
              
              <div>
                  <label style="color:var(--text-secondary); display:block; margin-bottom:5px;">Email</label>
                  <input type="email" name="email" id="edit-user-email" class="admin-input" style="width: 100%; padding: 10px; margin-bottom: 15px; background: #000; color: #fff; border: 1px solid rgba(0, 245, 255, 0.3); border-radius: 4px;" required>
              </div>
              
              <div>
                  <label style="color:var(--text-secondary); display:block; margin-bottom:5px;">System Role</label>
                  <select name="role" id="edit-user-role" class="admin-input" style="width: 100%; padding: 10px; margin-bottom: 15px; background: #000; color: #fff; border: 1px solid rgba(0, 245, 255, 0.3); border-radius: 4px;">
                      <option value="client">Client</option>
                      <option value="admin">Admin</option>
                  </select>
              </div>
              
              <button type="submit" class="btn btn-primary btn-full" style="width: 100%; margin-top: 10px;">Update User</button>
          </form>
      </div>
  </div>

  <script>
    function openEditUserModal(id, username, email, role) {
        document.getElementById('edit-user-id').value = id;
        document.getElementById('edit-user-username').value = username;
        document.getElementById('edit-user-email').value = email;
        document.getElementById('edit-user-role').value = role;
        document.getElementById('edit-user-modal').style.display = 'flex';
    }
  </script>
</body>
</html>