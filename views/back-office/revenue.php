<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue &mdash; NEXUS//VAULT Admin</title>
    <meta name="description" content="Revenue analytics for NEXUS//VAULT.">
    <link rel="icon" type="image/png" href="/assets/icons/controller.png">
    <link rel="stylesheet" href="/assets/css/styles.css">
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
                    <li><a href="/admin/games/add">🎮 Games</a></li>
                    <li><a href="/admin/users">👥 Users</a></li>
                    <li><a href="/admin/revenue" class="active">💰 Revenue</a></li>
                    <li><a href="/admin/settings">⚙️ Settings</a></li>
                </ul>
            </aside>

            <!-- Main Content -->
            <div class="dashboard-main">
                <h1 class="dashboard-title">Revenue Analytics</h1>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <span class="stat-card-icon">💰</span>
                        <span class="stat-card-value">$<?= number_format($totalRevenue, 2) ?></span>
                        <span class="stat-card-label">Total Revenue</span>
                        <span class="stat-card-change positive">Server Processed</span>
                    </div>

                    <div class="stat-card accent-green">
                        <span class="stat-card-icon">📈</span>
                        <span class="stat-card-value"><?= $totalOrdersCount ?></span>
                        <span class="stat-card-label">Total Valid Orders</span>
                        <span class="stat-card-change positive">Cart Transactions</span>
                    </div>

                    <div class="stat-card accent-yellow">
                        <span class="stat-card-icon">💳</span>
                        <span class="stat-card-value">$<?= number_format($avgTransaction, 2) ?></span>
                        <span class="stat-card-label">Avg Transaction</span>
                        <span class="stat-card-change positive">Cart Average</span>
                    </div>

                    <div class="stat-card accent-pink">
                        <span class="stat-card-icon">💸</span>
                        <span class="stat-card-value">0.0%</span>
                        <span class="stat-card-label">Refund Rate</span>
                        <span class="stat-card-change positive">No Chargebacks</span>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="charts-row">
                    <!-- Main Revenue Chart -->
                    <div class="chart-container chart-large">
                        <h3 class="chart-title">Revenue Trends (2025)</h3>
                        <div class="bar-chart">
                            <!-- Reusing bar chart structure -->
                            <div class="bar-chart-item">
                                <div class="bar" style="height: 45%;"><span class="bar-value">$18K</span></div><span
                                    class="bar-label">Jan</span>
                            </div>
                            <div class="bar-chart-item">
                                <div class="bar" style="height: 55%;"><span class="bar-value">$22K</span></div><span
                                    class="bar-label">Feb</span>
                            </div>
                            <div class="bar-chart-item">
                                <div class="bar" style="height: 65%;"><span class="bar-value">$26K</span></div><span
                                    class="bar-label">Mar</span>
                            </div>
                            <div class="bar-chart-item">
                                <div class="bar" style="height: 70%;"><span class="bar-value">$28K</span></div><span
                                    class="bar-label">Apr</span>
                            </div>
                            <div class="bar-chart-item">
                                <div class="bar" style="height: 85%;"><span class="bar-value">$34K</span></div><span
                                    class="bar-label">May</span>
                            </div>
                            <div class="bar-chart-item">
                                <div class="bar" style="height: 65%;"><span class="bar-value">$26K</span></div><span
                                    class="bar-label">Jun</span>
                            </div>
                            <div class="bar-chart-item">
                                <div class="bar" style="height: 95%;"><span class="bar-value">$38K</span></div><span
                                    class="bar-label">Jul</span>
                            </div>
                            <div class="bar-chart-item">
                                <div class="bar" style="height: 80%;"><span class="bar-value">$32K</span></div><span
                                    class="bar-label">Aug</span>
                            </div>
                            <div class="bar-chart-item">
                                <div class="bar" style="height: 60%;"><span class="bar-value">$24K</span></div><span
                                    class="bar-label">Sep</span>
                            </div>
                            <div class="bar-chart-item">
                                <div class="bar" style="height: 75%;"><span class="bar-value">$30K</span></div><span
                                    class="bar-label">Oct</span>
                            </div>
                            <div class="bar-chart-item">
                                <div class="bar" style="height: 50%;"><span class="bar-value">$20K</span></div><span
                                    class="bar-label">Nov</span>
                            </div>
                            <div class="bar-chart-item">
                                <div class="bar" style="height: 100%;"><span class="bar-value">$40K</span></div><span
                                    class="bar-label">Dec</span>
                            </div>
                        </div>
                    </div>

                    <!-- Revenue Sources -->
                    <div class="chart-container">
                        <h3 class="chart-title">Revenue by Region</h3>
                        <div class="donut-chart">
                            <div class="donut">
                                <div class="donut-center">
                                    <span class="donut-value">Global</span>
                                </div>
                            </div>
                            <div class="donut-legend">
                                <div class="legend-item"><span class="legend-color cyan"></span><span>NA (45%)</span>
                                </div>
                                <div class="legend-item"><span class="legend-color magenta"></span><span>EU (30%)</span>
                                </div>
                                <div class="legend-item"><span class="legend-color yellow"></span><span>ASIA
                                        (15%)</span></div>
                                <div class="legend-item"><span class="legend-color green"></span><span>ROW (10%)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transactions Table -->
                <div class="chart-container">
                    <h3 class="chart-title">Recent Transactions</h3>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>User</th>
                                <th>Game</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($orders)): ?>
                                <?php foreach(array_slice($orders, 0, 5) as $order): ?>
                                <tr>
                                    <td class="text-mono">#TRX-<?= str_pad($order['id'], 4, '0', STR_PAD_LEFT) ?></td>
                                    <td><?= htmlspecialchars($order['username'] ?? 'User #'.$order['user_id']) ?></td>
                                    <td>Cart Bundle</td>
                                    <td class="text-green">$<?= number_format($order['total_price'], 2) ?></td>
                                    <td><?= htmlspecialchars($order['created_at']) ?></td>
                                    <td><span class="status-badge active">Completed</span></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6">No recent transactions located in mainframe.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </main>
</body>

</html>