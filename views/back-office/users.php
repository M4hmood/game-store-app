<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Users - NEXUS VAULT</title>
  <link rel="icon" type="image/png" href="/assets/icons/controller.png">
  <link rel="stylesheet" href="/assets/css/styles.css">
  <style>
    .admin-input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      background: #000;
      color: #fff;
      border: 1px solid rgba(0, 245, 255, 0.3);
      border-radius: 4px;
    }

    #edit-user-modal {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(10, 10, 15, 0.9);
      z-index: 2000;
      align-items: center;
      justify-content: center;
      backdrop-filter: blur(5px);
    }

    .modal-content {
      background: var(--bg-secondary);
      padding: 30px;
      border-radius: 8px;
      border: 1px solid var(--neon-cyan);
      max-width: 500px;
      width: 100%;
      position: relative;
      box-shadow: var(--glow-cyan);
    }

    .close-btn {
      position: absolute;
      top: 15px;
      right: 15px;
      background: transparent;
      border: none;
      color: white;
      cursor: pointer;
      font-size: 1.5rem;
      transition: color 0.3s ease;
    }

    .close-btn:hover {
      color: var(--neon-cyan);
    }
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

  <!-- Users Management -->
  <main class="dashboard">
    <div class="dashboard-grid">
      <!-- Sidebar -->
      <aside class="dashboard-sidebar">
        <ul class="sidebar-menu">
          <li><a href="/admin">📊 Overview</a></li>
          <li><a href="/admin/games/add">🎮 Games</a></li>
          <li><a href="/admin/users" class="active">👥 Users</a></li>
          <li><a href="/admin/revenue">💰 Revenue</a></li>
          <li><a href="/admin/settings">⚙️ Settings</a></li>
        </ul>
      </aside>

      <!-- Main Content -->
      <div class="dashboard-main">
        <h1 class="dashboard-title">User Management</h1>

        <!-- Users Stats -->
        <div class="stats-grid" style="margin-bottom: 2rem;">
          <div class="stat-card">
            <span class="stat-card-icon">👥</span>
            <span class="stat-card-value"><?= count($users ?? []) ?></span>
            <span class="stat-card-label">Total Users</span>
            <span class="stat-card-change positive">Registered</span>
          </div>
        </div>

        <!-- Users Table -->
        <div class="users-table-container">
          <table class="users-table" style="width: 100%; color: white; text-align: left; border-collapse: collapse;">
            <thead>
              <tr style="border-bottom: 1px solid var(--neon-cyan);">
                <th style="padding: 10px;">ID</th>
                <th style="padding: 10px;">Username</th>
                <th style="padding: 10px;">Email</th>
                <th style="padding: 10px;">Role</th>
                <th style="padding: 10px;">Join Date</th>
                <th style="padding: 10px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                  <tr class="user-row" style="border-bottom: 1px solid #333;">
                    <td class="user-id" style="padding: 10px;">#<?= htmlspecialchars($user['id']) ?></td>
                    <td class="user-name" style="padding: 10px;"><?= htmlspecialchars($user['username']) ?></td>
                    <td class="user-email" style="padding: 10px;"><?= htmlspecialchars($user['email']) ?></td>
                    <td style="padding: 10px;">
                      <span class="status-badge <?= $user['role'] === 'admin' ? 'active' : 'inactive' ?>"
                        style="padding: 5px; border-radius: 4px; font-size: 0.8rem; border: 1px solid <?= $user['role'] === 'admin' ? 'var(--neon-green)' : 'gray' ?>;">
                        <?= htmlspecialchars(strtoupper($user['role'] ?? 'CLIENT')) ?>
                      </span>
                    </td>
                    <td class="user-date" style="padding: 10px;"><?= htmlspecialchars($user['created_at']) ?></td>
                    <td class="user-actions" style="padding: 10px; display:flex; gap: 5px;">
                      <button class="btn btn-sm btn-primary"
                        onclick="openEditUserModal(<?= $user['id'] ?>, '<?= htmlspecialchars(addslashes($user['username'])) ?>', '<?= htmlspecialchars(addslashes($user['email'])) ?>', '<?= htmlspecialchars(addslashes($user['role'] ?? 'client')) ?>')">Edit</button>

                      <?php if ($user['id'] != $_SESSION['user_id']): ?>
                        <form method="POST" action="/admin/users/delete" style="margin:0;">
                          <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                          <button type="submit" class="btn btn-sm"
                            style="background:#ff4444; color:white; border:none;">Ban</button>
                        </form>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" style="padding: 20px;">No users found in database.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <div id="edit-user-modal">
    <div class="modal-content">
      <button class="close-btn"
        onclick="document.getElementById('edit-user-modal').style.display='none'">&times;</button>
      <h2 style="color:var(--neon-cyan); margin-bottom: 20px; font-family: var(--font-display);">Modify User Protocol
      </h2>

      <form action="/admin/users/edit" method="POST">
        <input type="hidden" name="user_id" id="edit-user-id">

        <div>
          <label class="setting-label"
            style="color:var(--text-secondary); display:block; margin-bottom:5px;">Username</label>
          <input type="text" name="username" id="edit-user-username" class="admin-input" required>
        </div>

        <div>
          <label class="setting-label"
            style="color:var(--text-secondary); display:block; margin-bottom:5px;">Email</label>
          <input type="email" name="email" id="edit-user-email" class="admin-input" required>
        </div>

        <div>
          <label class="setting-label" style="color:var(--text-secondary); display:block; margin-bottom:5px;">System
            Role</label>
          <select name="role" id="edit-user-role" class="admin-input">
            <option value="client">Client (Standard)</option>
            <option value="admin">Admin (Elevated)</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary btn-full" style="margin-top: 10px;">Update Network Node</button>
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