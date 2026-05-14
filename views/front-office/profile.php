<?php
$activeTab = $activeTab ?? 'account';
$flash = $flash ?? null;
$editPayment = $editPayment ?? null;
?>
<style>
    .profile-tabs { display: flex; gap: 10px; margin-bottom: 25px; border-bottom: 1px solid rgba(0, 245, 255, 0.3); flex-wrap: wrap; }
    .profile-tab { padding: 12px 22px; color: #aaa; text-decoration: none; font-family: var(--font-display, monospace); text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid transparent; transition: all 0.2s; }
    .profile-tab:hover { color: var(--neon-cyan, #00f5ff); }
    .profile-tab.active { color: var(--neon-cyan, #00f5ff); border-bottom-color: var(--neon-cyan, #00f5ff); }
    .profile-section { background: rgba(255, 255, 255, 0.04); padding: 25px; border-radius: 8px; border: 1px solid rgba(0, 245, 255, 0.15); }
    .profile-flash { padding: 12px 16px; margin-bottom: 18px; border-radius: 5px; color: white; }
    .profile-flash.success { background: rgba(0, 255, 100, 0.12); border: 1px solid var(--neon-green, #00ff64); }
    .profile-flash.error { background: rgba(255, 0, 0, 0.12); border: 1px solid #ff4040; }
    .payment-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 18px; margin-bottom: 25px; }
    .payment-card { background: linear-gradient(135deg, rgba(0, 245, 255, 0.1), rgba(255, 0, 200, 0.08)); border: 1px solid rgba(0, 245, 255, 0.3); border-radius: 10px; padding: 18px; color: white; position: relative; }
    .payment-card.default { border-color: var(--neon-green, #00ff64); box-shadow: 0 0 12px rgba(0, 255, 100, 0.25); }
    .payment-card .brand { font-family: var(--font-display, monospace); text-transform: uppercase; letter-spacing: 2px; color: var(--neon-yellow, #ffeb3b); margin-bottom: 12px; }
    .payment-card .number { font-family: monospace; font-size: 1.2rem; letter-spacing: 2px; margin-bottom: 14px; }
    .payment-card .meta { display: flex; justify-content: space-between; font-size: 0.85rem; color: #ccc; margin-bottom: 12px; }
    .payment-card .actions { display: flex; gap: 8px; flex-wrap: wrap; }
    .payment-card .default-badge { position: absolute; top: 10px; right: 10px; background: var(--neon-green, #00ff64); color: #000; font-size: 0.7rem; padding: 3px 8px; border-radius: 3px; font-weight: bold; text-transform: uppercase; }
    .form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
    .form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; }
    @media (max-width: 600px) {
        .form-row-2, .form-row-3 { grid-template-columns: 1fr; }
    }
</style>

<div class="store-container" style="padding-top: 100px; min-height: 80vh;">
    <?php if (isset($_GET['transaction']) && $_GET['transaction'] === 'completed'): ?>
        <?php $lastPayment = $_SESSION['last_payment'] ?? null; unset($_SESSION['last_payment']); ?>
        <div class="profile-flash success" style="display: flex; flex-wrap: wrap; align-items: center; gap: 14px;">
            <span style="font-size: 1.5rem;">&#x2714;</span>
            <div style="flex: 1; min-width: 220px;">
                <strong>Payment Successful!</strong>
                <?php if ($lastPayment): ?>
                    Charged to your <strong><?= htmlspecialchars($lastPayment['brand']) ?></strong>
                    <span style="font-family: monospace;"><?= htmlspecialchars($lastPayment['masked']) ?></span>
                    (<?= htmlspecialchars($lastPayment['holder']) ?>).
                <?php endif; ?>
                <br>Your new game has been added to your library.
            </div>
        </div>
    <?php endif; ?>

    <?php if ($flash): ?>
        <div class="profile-flash <?= htmlspecialchars($flash['type']) ?>">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
    <?php endif; ?>

    <h2 class="dashboard-title" style="color: white; margin-bottom: 20px;">My Profile</h2>

    <nav class="profile-tabs">
        <a href="/profile?tab=account" class="profile-tab <?= $activeTab === 'account' ? 'active' : '' ?>">Account</a>
        <a href="/profile?tab=payment" class="profile-tab <?= $activeTab === 'payment' ? 'active' : '' ?>">Payment Methods</a>
        <a href="/profile?tab=library" class="profile-tab <?= $activeTab === 'library' ? 'active' : '' ?>">Library</a>
    </nav>

    <?php if ($activeTab === 'account'): ?>
        <section class="profile-section">
            <h3 style="color: var(--neon-cyan, #00f5ff); margin-bottom: 20px;">Account Details</h3>
            <form action="/profile/update" method="POST">
                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label" for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-input" value="<?= htmlspecialchars($user['username']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-input" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                </div>

                <h4 style="color: white; margin: 25px 0 12px;">Change Password <span style="color:#888; font-weight:normal; font-size:0.85rem;">(leave blank to keep current)</span></h4>

                <div class="form-group">
                    <label class="form-label" for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="form-input" autocomplete="current-password">
                </div>
                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label" for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="form-input" autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-input" autocomplete="new-password">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: 15px;">Save Changes</button>
            </form>
        </section>

    <?php elseif ($activeTab === 'payment'): ?>
        <section class="profile-section">
            <h3 style="color: var(--neon-cyan, #00f5ff); margin-bottom: 20px;">Saved Payment Methods</h3>

            <?php if (empty($paymentMethods)): ?>
                <p style="color: gray; margin-bottom: 20px;">No payment methods on file. Add one below to speed up checkout.</p>
            <?php else: ?>
                <div class="payment-grid">
                    <?php foreach ($paymentMethods as $pm): ?>
                        <div class="payment-card <?= $pm['is_default'] ? 'default' : '' ?>">
                            <?php if ($pm['is_default']): ?>
                                <span class="default-badge">Default</span>
                            <?php endif; ?>
                            <div class="brand"><?= htmlspecialchars($pm['brand']) ?></div>
                            <div class="number"><?= htmlspecialchars(PaymentMethod::maskNumber($pm['card_number'])) ?></div>
                            <div class="meta">
                                <span><?= htmlspecialchars($pm['card_holder']) ?></span>
                                <span><?= str_pad($pm['expiry_month'], 2, '0', STR_PAD_LEFT) ?>/<?= substr($pm['expiry_year'], -2) ?></span>
                            </div>
                            <div class="actions">
                                <a href="/profile?tab=payment&edit=<?= $pm['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
                                <?php if (!$pm['is_default']): ?>
                                    <form action="/profile/payment/default" method="POST" style="margin:0;">
                                        <input type="hidden" name="id" value="<?= $pm['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-accent">Set Default</button>
                                    </form>
                                <?php endif; ?>
                                <form action="/profile/payment/delete" method="POST" style="margin:0;" onsubmit="return confirm('Delete this payment method?');">
                                    <input type="hidden" name="id" value="<?= $pm['id'] ?>">
                                    <button type="submit" class="btn btn-sm" style="background: rgba(255,0,0,0.8); border:none; color:white;">Delete</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <h4 style="color: white; margin-bottom: 15px;"><?= $editPayment ? 'Edit Payment Method' : 'Add New Payment Method' ?></h4>
            <form action="<?= $editPayment ? '/profile/payment/update' : '/profile/payment/add' ?>" method="POST">
                <?php if ($editPayment): ?>
                    <input type="hidden" name="id" value="<?= $editPayment['id'] ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label class="form-label" for="card_holder">Card Holder Name</label>
                    <input type="text" id="card_holder" name="card_holder" class="form-input" placeholder="JOHN DOE" value="<?= $editPayment ? htmlspecialchars($editPayment['card_holder']) : '' ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="card_number">Card Number</label>
                    <input type="text" id="card_number" name="card_number" class="form-input" placeholder="4242 4242 4242 4242" maxlength="23" value="<?= $editPayment ? htmlspecialchars($editPayment['card_number']) : '' ?>" required inputmode="numeric">
                </div>

                <div class="form-row-3">
                    <div class="form-group">
                        <label class="form-label" for="expiry_month">Month</label>
                        <select id="expiry_month" name="expiry_month" class="form-input" required>
                            <option value="">MM</option>
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= $m ?>" <?= $editPayment && (int)$editPayment['expiry_month'] === $m ? 'selected' : '' ?>><?= str_pad($m, 2, '0', STR_PAD_LEFT) ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="expiry_year">Year</label>
                        <select id="expiry_year" name="expiry_year" class="form-input" required>
                            <option value="">YYYY</option>
                            <?php $cy = (int)date('Y'); for ($y = $cy; $y <= $cy + 15; $y++): ?>
                                <option value="<?= $y ?>" <?= $editPayment && (int)$editPayment['expiry_year'] === $y ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" class="form-input" placeholder="123" maxlength="4" value="<?= $editPayment ? htmlspecialchars($editPayment['cvv']) : '' ?>" required inputmode="numeric">
                    </div>
                </div>

                <div class="form-group">
                    <label class="checkbox-label" style="color: white;">
                        <input type="checkbox" name="is_default" value="1" <?= $editPayment && $editPayment['is_default'] ? 'checked' : '' ?>>
                        <span>Set as default payment method</span>
                    </label>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 15px;">
                    <button type="submit" class="btn btn-primary"><?= $editPayment ? 'Update Card' : 'Add Card' ?></button>
                    <?php if ($editPayment): ?>
                        <a href="/profile?tab=payment" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>
        </section>

    <?php else: ?>
        <section class="profile-section">
            <h3 style="color: var(--neon-cyan, #00f5ff); margin-bottom: 20px;">My Purchased Games</h3>
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
                                    <a href="#" class="btn btn-secondary btn-sm">Play</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>
</div>

<script>
(function () {
    var input = document.getElementById('card_number');
    if (!input) return;
    input.addEventListener('input', function (e) {
        var v = e.target.value.replace(/\D/g, '').slice(0, 19);
        var parts = v.match(/.{1,4}/g);
        e.target.value = parts ? parts.join(' ') : '';
    });
    var cvv = document.getElementById('cvv');
    if (cvv) {
        cvv.addEventListener('input', function (e) {
            e.target.value = e.target.value.replace(/\D/g, '').slice(0, 4);
        });
    }
})();
</script>
