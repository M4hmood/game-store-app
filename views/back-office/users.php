<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Users &mdash; NEXUS//VAULT Admin</title>
  <link rel="icon" type="image/png" href="/assets/icons/controller.png">
  <link rel="stylesheet" href="/assets/css/styles.css">
  <style>
    #edit-user-modal {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.65);
      z-index: 2000;
      align-items: center;
      justify-content: center;
      backdrop-filter: blur(4px);
    }

    .modal-content {
      background: var(--bg-card);
      padding: 28px;
      border-radius: var(--radius-lg);
      border: 1px solid var(--border);
      max-width: 500px;
      width: calc(100% - 32px);
      position: relative;
      box-shadow: var(--shadow-lg);
    }

    .close-btn {
      position: absolute;
      top: 12px;
      right: 12px;
      background: transparent;
      border: none;
      color: var(--text-secondary);
      cursor: pointer;
      font-size: 1.5rem;
      line-height: 1;
      transition: color 0.15s ease;
    }

    .close-btn:hover {
      color: var(--text-primary);
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
        <span class="admin-badge">Admin</span>
        <a href="/logout" class="btn btn-secondary">Sign out</a>
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
              <tr style="border-bottom: 1px solid var(--border); color: var(--text-muted); text-transform: uppercase; font-size: 0.78rem; letter-spacing: 0.05em;">
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
                  <tr class="user-row" style="border-bottom: 1px solid var(--border-muted);">
                    <td class="user-id" style="padding: 12px 10px; color: var(--text-muted);">#<?= htmlspecialchars($user['id']) ?></td>
                    <td class="user-name" style="padding: 12px 10px;"><?= htmlspecialchars($user['username']) ?></td>
                    <td class="user-email" style="padding: 12px 10px; color: var(--text-secondary);"><?= htmlspecialchars($user['email']) ?></td>
                    <td style="padding: 12px 10px;">
                      <span class="status-badge <?= $user['role'] === 'admin' ? 'active' : 'inactive' ?>">
                        <?= htmlspecialchars($user['role'] ?? 'client') ?>
                      </span>
                    </td>
                    <td class="user-date" style="padding: 12px 10px; color: var(--text-secondary);"><?= htmlspecialchars($user['created_at']) ?></td>
                    <td class="user-actions" style="padding: 12px 10px; display:flex; gap: 6px;">
                      <button class="btn btn-sm btn-secondary"
                        onclick="openEditUserModal(<?= $user['id'] ?>, '<?= htmlspecialchars(addslashes($user['username'])) ?>', '<?= htmlspecialchars(addslashes($user['email'])) ?>', '<?= htmlspecialchars(addslashes($user['role'] ?? 'client')) ?>')">Edit</button>

                      <?php if ($user['id'] != $_SESSION['user_id']): ?>
                        <form method="POST" action="/admin/users/delete" style="margin:0;">
                          <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                          <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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
      <h2 style="color: var(--text-primary); margin-bottom: 20px; font-family: var(--font-display); font-size: 1.25rem; font-weight: 700;">Edit user</h2>

      <form action="/admin/users/edit" method="POST">
        <input type="hidden" name="user_id" id="edit-user-id">

        <div class="form-group">
          <label class="form-label">Username</label>
          <input type="text" name="username" id="edit-user-username" class="form-input" required>
        </div>

        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="email" id="edit-user-email" class="form-input" required>
        </div>

        <div class="form-group">
          <label class="form-label">Role</label>
          <select name="role" id="edit-user-role" class="form-input">
            <option value="client">Client</option>
            <option value="admin">Admin</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary btn-full" style="margin-top: 8px;">Save changes</button>
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