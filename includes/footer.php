<?php
// Ensure this file is included properly
?>
<footer class="site-footer" style="background-color: var(--emerald); color: var(--off-white-alt); padding: 80px 0 40px; border-top: 1px solid var(--emerald-hover);">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; margin-bottom: 60px;">
            
            <div>
                <h3 style="font-family: 'Cinzel', serif; color: var(--rose-gold); font-size: 1.4rem; margin-bottom: 20px;">Ayana Boutique</h3>
                <p style="font-size: 0.9rem; color: var(--off-white-alt); line-height: 1.8; opacity: 0.8;">
                    Curating timeless elegance and heritage weaves. Discover our exquisite collection of authentic Indian bridal and ethnic attire.
                </p>
            </div>

            <div>
                <h4 style="font-family: 'Cinzel', serif; color: var(--off-white); font-size: 1.1rem; margin-bottom: 20px;">Explore</h4>
                <ul style="list-style: none; padding: 0; font-size: 0.85rem;">
                    <li style="margin-bottom: 12px;"><a href="<?= e(base_url('categories.php')) ?>" style="color: var(--off-white-alt); text-decoration: none; opacity: 0.8; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='var(--rose-gold)';" onmouseout="this.style.opacity='0.8'; this.style.color='var(--off-white-alt)';">The Collection</a></li>
                    <li style="margin-bottom: 12px;"><a href="<?= e(base_url('about.php')) ?>" style="color: var(--off-white-alt); text-decoration: none; opacity: 0.8; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='var(--rose-gold)';" onmouseout="this.style.opacity='0.8'; this.style.color='var(--off-white-alt)';">Our Story</a></li>
                    <li style="margin-bottom: 12px;"><a href="<?= e(base_url('contact.php')) ?>" style="color: var(--off-white-alt); text-decoration: none; opacity: 0.8; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='var(--rose-gold)';" onmouseout="this.style.opacity='0.8'; this.style.color='var(--off-white-alt)';">Contact Us</a></li>
                </ul>
            </div>

            <div>
                <h4 style="font-family: 'Cinzel', serif; color: var(--off-white); font-size: 1.1rem; margin-bottom: 20px;">Client Services</h4>
                <ul style="list-style: none; padding: 0; font-size: 0.85rem;">
                    <li style="margin-bottom: 12px;"><a href="<?= e(base_url('account.php')) ?>" style="color: var(--off-white-alt); text-decoration: none; opacity: 0.8; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='var(--rose-gold)';" onmouseout="this.style.opacity='0.8'; this.style.color='var(--off-white-alt)';">My Account</a></li>
                    <li style="margin-bottom: 12px;"><a href="<?= e(base_url('shipping.php')) ?>" style="color: var(--off-white-alt); text-decoration: none; opacity: 0.8; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='var(--rose-gold)';" onmouseout="this.style.opacity='0.8'; this.style.color='var(--off-white-alt)';">Shipping Details</a></li>
                    <li style="margin-bottom: 12px;"><a href="<?= e(base_url('refunds.php')) ?>" style="color: var(--off-white-alt); text-decoration: none; opacity: 0.8; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='var(--rose-gold)';" onmouseout="this.style.opacity='0.8'; this.style.color='var(--off-white-alt)';">Returns & Exchanges</a></li>
                    <li style="margin-bottom: 12px;"><a href="<?= e(base_url('privacy.php')) ?>" style="color: var(--off-white-alt); text-decoration: none; opacity: 0.8; transition: opacity 0.3s ease;" onmouseover="this.style.opacity='1'; this.style.color='var(--rose-gold)';" onmouseout="this.style.opacity='0.8'; this.style.color='var(--off-white-alt)';">Privacy Policy</a></li>
                </ul>
            </div>
            
            <div>
                <h4 style="font-family: 'Cinzel', serif; color: var(--off-white); font-size: 1.1rem; margin-bottom: 20px;">Stay Connected</h4>
                <p style="font-size: 0.85rem; color: var(--off-white-alt); line-height: 1.6; opacity: 0.8; margin-bottom: 15px;">
                    Join our exclusive list for early access to new collections and bespoke offers.
                </p>
                <form action="#" method="post" style="display: flex; gap: 10px;">
                    <input type="email" placeholder="Email Address" style="width: 100%; padding: 10px 15px; border: 1px solid rgba(240, 232, 219, 0.3); background: transparent; color: var(--off-white); font-family: 'Jost', sans-serif; font-size: 0.85rem; outline: none;">
                    <button type="submit" style="background: var(--rose-gold); color: var(--off-white); border: none; padding: 10px 20px; cursor: pointer; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.1em; transition: background 0.3s ease;" onmouseover="this.style.background='var(--rose-gold-deep)'" onmouseout="this.style.background='var(--rose-gold)'">Join</button>
                </form>
            </div>
        </div>

        <div style="text-align: center; border-top: 1px solid rgba(240, 232, 219, 0.1); padding-top: 30px; font-size: 0.75rem; opacity: 0.6; letter-spacing: 0.1em; text-transform: uppercase;">
            &copy; <?= date('Y') ?> Ayana Boutique. All Rights Reserved.
        </div>
    </div>
</footer>

<script src="<?= e(base_url('js/main.js')) ?>"></script>
</body>
</html>