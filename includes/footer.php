<footer style="background-color: var(--emerald); color: var(--off-white); padding: 60px 0; margin-top: 40px; text-align: center;">
    <div class="container">
        <div style="margin-bottom: 24px;">
            <p class="cinzel" style="font-size: 1.5rem; color: var(--rose-gold); margin-bottom: 8px;">Ayana Boutique</p>
            <p class="accent-italic" style="color: var(--emerald-soft); font-size: 1.1rem;">Where Tradition Meets Trousseau</p>
        </div>
        
        <div style="display: flex; justify-content: center; gap: 32px; margin-bottom: 32px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em;">
            <a href="<?= e(base_url('categories.php')) ?>" style="color: var(--off-white);">Shop</a>
            <a href="<?= e(base_url('about.php')) ?>" style="color: var(--off-white);">Our Story</a>
            <a href="<?= e(base_url('contact.php')) ?>" style="color: var(--off-white);">Contact</a>
        </div>
        
        <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 24px; margin-bottom: 32px; font-size: 0.75rem; letter-spacing: 0.05em;">
            <a href="<?= e(base_url('terms.php')) ?>" style="color: var(--emerald-soft); transition: color 0.3s ease;" onmouseover="this.style.color='var(--rose-gold)'" onmouseout="this.style.color='var(--emerald-soft)'">Terms of Service</a>
            <a href="<?= e(base_url('shipping.php')) ?>" style="color: var(--emerald-soft); transition: color 0.3s ease;" onmouseover="this.style.color='var(--rose-gold)'" onmouseout="this.style.color='var(--emerald-soft)'">Shipping & Delivery</a>
            <a href="<?= e(base_url('refunds.php')) ?>" style="color: var(--emerald-soft); transition: color 0.3s ease;" onmouseover="this.style.color='var(--rose-gold)'" onmouseout="this.style.color='var(--emerald-soft)'">Refund & Exchange</a>
            <a href="<?= e(base_url('privacy.php')) ?>" style="color: var(--emerald-soft); transition: color 0.3s ease;" onmouseover="this.style.color='var(--rose-gold)'" onmouseout="this.style.color='var(--emerald-soft)'">Privacy Policy</a>
        </div>
        
        <div style="border-top: 1px solid rgba(220, 232, 227, 0.2); padding-top: 24px;">
            <p style="font-size: 0.8rem; color: var(--emerald-soft);">&copy; <?= date('Y') ?> Ayana Boutique. All rights reserved.</p>
        </div>
    </div>
</footer>
<script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>
</html>