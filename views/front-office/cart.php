<?php $cartError = $cartError ?? null; $paymentMethods = $paymentMethods ?? []; ?>
<div class="store-container" style="padding-top: 100px; min-height: 80vh;">
    <h2 class="dashboard-title" style="color: white; margin-bottom: 20px;">Shopping Cart</h2>

    <?php if ($cartError): ?>
        <div style="background-color: rgba(255,0,0,0.15); border: 1px solid #ff4040; color: white; padding: 12px 16px; margin-bottom: 18px; border-radius: 5px;">
            <?= htmlspecialchars($cartError) ?>
        </div>
    <?php endif; ?>

    <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 8px;">
        <?php if (empty($cartItems)): ?>
            <p style="color: gray;">Your cart is empty.</p>
            <a href="/store" class="btn btn-primary" style="margin-top: 15px;">Browse the store</a>
        <?php else: ?>
            <table style="width: 100%; color: white; border-collapse: collapse; font-family: var(--font-body);">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border); text-align: left; text-transform: uppercase; font-size: 0.78rem; color: var(--text-muted); letter-spacing: 0.05em;">
                        <th style="padding: 10px;">Item</th>
                        <th style="padding: 10px;">Price</th>
                        <th style="padding: 10px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                    <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <td style="padding: 15px 10px; font-weight: bold;"><?= htmlspecialchars($item['title']) ?></td>
                        <td style="padding: 15px 10px; color: var(--neon-yellow);">$<?= htmlspecialchars($item['price']) ?></td>
                        <td style="padding: 15px 10px;">
                            <form action="/cart/remove" method="POST" style="margin:0;">
                                <input type="hidden" name="game_id" value="<?= $item['id'] ?>">
                                <button type="submit" class="btn btn-sm" style="background: rgba(255, 0, 0, 0.8); border:none; color: white;">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td style="padding: 20px 10px 10px; font-weight: 600; color: var(--text-secondary);">Total</td>
                        <td style="padding: 20px 10px 10px; font-weight: 700; color: var(--text-primary); font-size: 1.25rem;">$<?= number_format($totalPrice, 2) ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <?php if (!isset($_SESSION['user_id'])): ?>
                <div style="margin-top: 25px; padding: 15px; background: rgba(255, 200, 0, 0.1); border: 1px solid var(--neon-yellow, #ffeb3b); border-radius: 5px; color: white;">
                    Please <a href="/signin" style="color: var(--neon-cyan, #00f5ff);">sign in</a> to complete your purchase.
                </div>
            <?php elseif (empty($paymentMethods)): ?>
                <div style="margin-top: 25px; padding: 15px; background: rgba(255, 200, 0, 0.1); border: 1px solid var(--neon-yellow, #ffeb3b); border-radius: 5px; color: white;">
                    You don't have any payment methods yet.
                    <a href="/profile?tab=payment" style="color: var(--neon-cyan, #00f5ff); margin-left: 6px;">Add one in your profile →</a>
                </div>
            <?php else: ?>
                <form action="/cart/checkout" method="POST" style="margin-top: 30px;">
                    <h3 style="color: var(--neon-cyan, #00f5ff); margin-bottom: 12px; font-size: 1rem; text-transform: uppercase; letter-spacing: 1px;">Select Payment Method</h3>
                    <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                        <?php foreach ($paymentMethods as $i => $pm):
                            $checked = $pm['is_default'] || (count($paymentMethods) === 1);
                        ?>
                            <label style="display: flex; align-items: center; gap: 12px; padding: 12px 15px; background: rgba(0, 245, 255, 0.05); border: 1px solid rgba(0, 245, 255, 0.2); border-radius: 6px; color: white; cursor: pointer;">
                                <input type="radio" name="payment_method_id" value="<?= $pm['id'] ?>" <?= $checked ? 'checked' : '' ?> required>
                                <span style="font-family: var(--font-display, monospace); color: var(--neon-yellow, #ffeb3b); min-width: 90px; text-transform: uppercase;"><?= htmlspecialchars($pm['brand']) ?></span>
                                <span style="font-family: monospace; letter-spacing: 1px;"><?= htmlspecialchars(PaymentMethod::maskNumber($pm['card_number'])) ?></span>
                                <span style="margin-left: auto; color: #ccc; font-size: 0.85rem;">
                                    <?= htmlspecialchars($pm['card_holder']) ?>
                                    &nbsp;·&nbsp;
                                    <?= str_pad($pm['expiry_month'], 2, '0', STR_PAD_LEFT) ?>/<?= substr($pm['expiry_year'], -2) ?>
                                </span>
                                <?php if ($pm['is_default']): ?>
                                    <span style="background: var(--neon-green, #00ff64); color: #000; font-size: 0.65rem; padding: 2px 6px; border-radius: 3px; font-weight: bold;">DEFAULT</span>
                                <?php endif; ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <div style="text-align: right;">
                        <a href="/profile?tab=payment" class="btn btn-secondary" style="margin-right: 8px;">Manage Cards</a>
                        <button type="submit" class="btn btn-primary btn-lg">Pay $<?= number_format($totalPrice, 2) ?></button>
                    </div>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
