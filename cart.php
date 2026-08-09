<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/cart_functions.php';

$pageTitle = 'Your Cart';
$items = cart_items();
$subtotal = cart_subtotal();
$shipping = $items ? 15.00 : 0; // Adjust this via your config constants if needed
$total = $subtotal + $shipping;

require __DIR__ . '/includes/header.php';
?>

<style>
    /* Luxury Cart Layout Styles */
    .cart-grid { 
        display: grid; 
        grid-template-columns: 2fr 1.2fr; 
        gap: 60px; 
        align-items: start; 
        margin-top: 30px; 
    }
    @media (max-width: 900px) { .cart-grid { grid-template-columns: 1fr; gap: 40px; } }
    
    /* Cart Items List */
    .cart-item { 
        display: grid; 
        grid-template-columns: 120px 1fr auto; 
        gap: 30px; 
        padding: 30px 0; 
        border-bottom: 1px solid var(--emerald-soft); 
        align-items: center; 
    }
    .cart-item:first-child { border-top: 1px solid var(--emerald-soft); }
    
    .cart-img-wrap img { 
        width: 100%; 
        height: 160px; 
        object-fit: cover; 
        background: var(--off-white-alt); 
        border-radius: 2px; 
    }
    
    .cart-details .brand { 
        font-size: 0.75rem; 
        text-transform: uppercase; 
        letter-spacing: 0.15em; 
        color: var(--rose-gold); 
        margin-bottom: 6px; 
        display: block; 
    }
    .cart-details .name { 
        font-size: 1.4rem; 
        color: var(--emerald); 
        font-family: 'Cinzel', serif; 
        margin-bottom: 8px; 
    }
    .cart-details .size { 
        font-size: 0.85rem; 
        color: var(--ink-soft); 
        text-transform: uppercase; 
        letter-spacing: 0.05em; 
        margin-bottom: 16px; 
    }
    
    .cart-actions { 
        display: flex; 
        align-items: center; 
        gap: 20px; 
    }
    .qty-stepper input { 
        width: 60px; 
        padding: 10px; 
        border: 1px solid var(--emerald-soft); 
        text-align: center; 
        font-family: 'Jost', sans-serif; 
        background: transparent; 
        color: var(--ink);
    }
    .remove-link { 
        font-size: 0.75rem; 
        text-transform: uppercase; 
        letter-spacing: 0.1em; 
        color: var(--ink-soft); 
        cursor: pointer; 
        transition: color 0.3s ease; 
    }
    .remove-link:hover { color: var(--rose-gold); }
    
    .cart-price { 
        font-size: 1.1rem; 
        color: var(--ink); 
        text-align: right; 
        font-weight: 500;
    }
    
    /* Summary Box */
    .summary-box { 
        background: var(--off-white-alt); 
        padding: 40px; 
        border: 1px solid var(--emerald-soft); 
    }
    .summary-box h3 { 
        font-size: 1.5rem; 
        border-bottom: 1px solid var(--emerald-soft); 
        padding-bottom: 20px; 
        margin-bottom: 24px; 
    }
    .summary-row { 
        display: flex; 
        justify-content: space-between; 
        font-size: 0.95rem; 
        margin-bottom: 16px; 
        color: var(--ink-soft); 
    }
    .summary-row.total { 
        font-size: 1.4rem; 
        color: var(--emerald); 
        font-family: 'Cinzel', serif; 
        border-top: 1px solid var(--emerald-soft); 
        padding-top: 24px; 
        margin-top: 12px; 
    }
</style>

<nav class="breadcrumb container" style="padding-top: 40px; padding-bottom: 0;">
    <a href="<?= e(base_url('index.php')) ?>">Home</a>
    <span class="sep">/</span>
    <span class="current">Cart</span>
</nav>

<section class="section" style="padding-top: 30px; min-height: 60vh;">
    <div class="container">
        
        <div class="section-head" style="margin-bottom: 40px;">
            <span class="eyebrow">Your Selection</span>
            <h2>The Trousseau Edit</h2>
        </div>

        <?php if (!$items): ?>
            <div class="empty-state" style="text-align: center; padding: 60px 20px; border: 1px solid var(--emerald-soft);">
                <h3 style="margin-bottom: 16px;">Your cart is empty</h3>
                <p style="color: var(--ink-soft); margin-bottom: 30px;">Begin your trousseau — explore sarees, suits and more.</p>
                <a href="<?= e(base_url('categories.php')) ?>" class="btn btn-primary">Explore The Collection</a>
            </div>
        <?php else: ?>
            <div class="cart-grid">
                
                <div class="cart-items-list">
                    <?php foreach ($items as $key => $item): ?>
                    <div class="cart-item">
                        
                        <div class="cart-img-wrap">
                            <img src="<?= e(product_image_url($item['image'])) ?>" alt="<?= e($item['name']) ?>">
                        </div>
                        
                        <div class="cart-details">
                            <span class="brand">Ayana Boutique</span>
                            <div class="name"><?= e($item['name']) ?></div>
                            <?php if (!empty($item['size'])): ?>
                                <div class="size">Size: <?= e($item['size']) ?></div>
                            <?php endif; ?>
                            
                            <div class="cart-actions">
                                <div class="qty-stepper">
                                    <input type="number" min="1" value="<?= (int) $item['qty'] ?>" class="cart-qty-input" data-key="<?= e($key) ?>">
                                </div>
                                <a href="#" class="remove-link" data-key="<?= e($key) ?>">Remove</a>
                            </div>
                        </div>
                        
                        <div class="cart-price">
                            <?= e(format_price($item['price'] * $item['qty'])) ?>
                        </div>
                        
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="summary-box">
                    <h3>Order Summary</h3>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span><?= e(format_price($subtotal)) ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span><?= $shipping > 0 ? e(format_price($shipping)) : 'Complimentary' ?></span>
                    </div>
                    
                    <div class="summary-row total">
                        <span>Total</span>
                        <span><?= e(format_price($total)) ?></span>
                    </div>
                    
                    <a href="<?= e(base_url('checkout.php')) ?>" class="btn btn-primary btn-block" style="margin-top: 24px; background-color: var(--emerald); color: var(--off-white);">Proceed to Checkout</a>
                    <a href="<?= e(base_url('categories.php')) ?>" style="display:block; text-align:center; margin-top: 20px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--ink-soft); transition: color 0.3s ease;" onmouseover="this.style.color='var(--rose-gold)'" onmouseout="this.style.color='var(--ink-soft)'">Continue Shopping</a>
                </div>
                
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>