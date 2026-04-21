<div class="store-container" style="padding-top: 100px; min-height: 80vh;">
    <h2 class="dashboard-title" style="color: white; margin-bottom: 20px;">Shopping Cart</h2>
    
    <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 8px;">
        <?php if (empty($cartItems)): ?>
            <p style="color: gray;">Your cart is empty.</p>
            <a href="/store" class="btn btn-primary" style="margin-top: 15px;">Return to Terminal Store</a>
        <?php else: ?>
            <table style="width: 100%; color: white; border-collapse: collapse; font-family: var(--font-body);">
                <thead>
                    <tr style="border-bottom: 1px solid rgba(0, 245, 255, 0.3); text-align: left; text-transform: uppercase;">
                        <th style="padding: 10px;">Network Payload (Item)</th>
                        <th style="padding: 10px;">Credits (Price)</th>
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
                        <td style="padding: 20px 10px 10px; font-weight: bold; font-family: var(--font-display);">Total Value:</td>
                        <td style="padding: 20px 10px 10px; font-weight: bold; color: var(--neon-green); font-size: 1.25rem;">$<?= number_format($totalPrice, 2) ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            
            <form action="/cart/checkout" method="POST" style="margin-top: 30px; text-align: right;">
                <button type="submit" class="btn btn-primary btn-lg">Finalize Transaction</button>
            </form>
        <?php endif; ?>
    </div>
</div>
