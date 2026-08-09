<?php
// Ensure this is included within an active session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' | Ayana Boutique' : 'Ayana Boutique' ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    
    <style>
        /* Refined Design Tokens */
        :root {
            --off-white: #FAF6F0;
            --off-white-alt: #F0E8DB;
            --emerald: #0B4F3F;
            --emerald-hover: #146356;
            --emerald-soft: #DCE8E3;
            --rose-gold: #B76E79;
            --rose-gold-deep: #9B5661;
            --rose-gold-soft: #F0DCDD;
            --ink: #2C2620;
            --ink-soft: #5A524A;
        }

        /* Elegant Resets & Animations */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Jost', sans-serif; 
            background-color: var(--off-white); 
            color: var(--ink); 
            line-height: 1.8; 
            -webkit-font-smoothing: antialiased; 
            animation: fadeIn 1.2s ease-in-out;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* Typography - Delicate & Spacious */
        h1, h2, h3, h4, h5, h6, .cinzel { 
            font-family: 'Cinzel', serif; 
            font-weight: 400; 
            color: var(--emerald); 
            letter-spacing: 0.04em;
        }
        h1 { font-size: 2.8rem; line-height: 1.2; margin-bottom: 24px; }
        h2 { font-size: 2.2rem; margin-bottom: 16px; }
        .accent-italic { 
            font-family: 'Cormorant Garamond', serif; 
            font-style: italic; 
            color: var(--rose-gold); 
            font-size: 1.3rem;
        }
        a { text-decoration: none; color: var(--emerald); transition: color 0.4s ease; }

        /* Layout Structure - Widened to 1400px for luxury editorial breathing room */
        .container { width: 100%; max-width: 1400px; margin: 0 auto; padding: 0 40px; }
        .section { padding: 100px 0; } 
        .section-alt { background-color: var(--off-white-alt); }
        .section-emerald { background-color: var(--emerald); color: var(--off-white); }
        .section-emerald h2, .section-emerald p { color: var(--off-white); }

        /* Navigation - Minimalist & Airy */
        .site-header { 
            padding: 32px 0; 
            background-color: transparent; 
            position: relative;
            z-index: 10;
        }
        .nav-flex { display: flex; justify-content: space-between; align-items: center; }
        
        /* Brand Logo Styling */
        .brand-logo { 
            font-family: 'Cinzel', serif; 
            font-size: 1.6rem; 
            color: var(--emerald); 
            font-weight: 400; 
            letter-spacing: 0.08em; 
            display: flex; 
            align-items: center; 
            gap: 20px; 
        }
        
        .nav-links a { 
            margin-left: 35px; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
            letter-spacing: 0.15em; 
        }
        .nav-links a:hover { color: var(--rose-gold); }

        /* Buttons - Editorial Outline Style */
        .btn { 
            display: inline-block; 
            padding: 16px 36px; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 0.15em; 
            text-align: center; 
            cursor: pointer; 
            transition: all 0.4s ease; 
            background: transparent;
        }
        .btn-primary { color: var(--emerald); border: 1px solid var(--emerald); }
        .btn-primary:hover { background-color: var(--emerald); color: var(--off-white); }
        .btn-rose { color: var(--rose-gold); border: 1px solid var(--rose-gold); }
        .btn-rose:hover { background-color: var(--rose-gold); color: var(--off-white); }
        .btn-block { display: block; width: 100%; }

        /* Utility & Details */
        .eyebrow { 
            display: block; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
            letter-spacing: 0.2em; 
            color: var(--rose-gold); 
            margin-bottom: 16px; 
        }

        /* Text-Only Category Cards */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }
        .category-card { 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            background-color: transparent; 
            padding: 80px 20px; 
            text-align: center; 
            border: 1px solid var(--emerald-soft);
            transition: all 0.5s ease; 
        }
        .category-card h3 { 
            color: var(--emerald); 
            font-size: 1.4rem;
            margin-bottom: 12px; 
            transition: color 0.4s ease;
        }
        .category-card span {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--ink-soft);
            transition: color 0.4s ease;
        }
        .category-card:hover { background-color: var(--off-white-alt); border-color: var(--rose-gold); }
        .category-card:hover h3, .category-card:hover span { color: var(--rose-gold); }

        /* Hero Section - Centered & Editorial */
        .hero { text-align: center; padding-top: 20px; }
        .hero-copy { max-width: 800px; margin: 0 auto 50px; }
        .hero-copy h1 { margin-bottom: 20px; }
        .hero-copy .lede { margin-top: 24px; color: var(--ink-soft); font-size: 1.1rem; }

        /* Hero Image - Expansive and Elegant */
        .hero-visual img { 
            width: 100%; 
            height: auto; 
            max-height: 750px; 
            object-fit: cover; 
            border-radius: 2px; 
            box-shadow: 0 10px 40px rgba(11, 79, 63, 0.08);
        }

        /* Product List Images */
        .product-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); 
            gap: 40px; 
        }
        .product-card { text-align: left; }
        .product-thumb img { 
            width: 100%; 
            height: 380px; 
            object-fit: cover; 
            background-color: var(--off-white-alt);
        }
        .product-info { margin-top: 16px; }
        .product-info h3 { font-size: 1rem; margin-bottom: 4px; }

        /* Two-Column Product Overview Page */
        .product-layout { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 80px; 
            align-items: start; 
            margin-top: 20px; 
        }

        .gallery-main img { 
            width: 100%; 
            max-height: 650px; 
            object-fit: cover; 
            background-color: var(--off-white-alt);
        }
        .gallery-thumbs { 
            display: flex; 
            gap: 12px; 
            margin-top: 12px; 
        }
        .gallery-thumbs img { 
            width: 70px; 
            height: 90px; 
            object-fit: cover; 
            cursor: pointer; 
            border: 1px solid var(--emerald-soft); 
            opacity: 0.6; 
            transition: all 0.3s ease; 
        }
        .gallery-thumbs img.active, .gallery-thumbs img:hover { 
            opacity: 1; 
            border-color: var(--emerald); 
        }

        .pd-info .pd-title { font-size: 2rem; margin-bottom: 12px; }
        .pd-price { font-size: 1.2rem; color: var(--ink-soft); margin-bottom: 30px; }

        .size-options { display: flex; flex-wrap: wrap; gap: 10px; margin: 12px 0 30px; }
        .size-options input[type="radio"] { display: none; }
        .size-options label { 
            padding: 12px 20px; 
            border: 1px solid var(--emerald-soft); 
            cursor: pointer; 
            font-size: 0.8rem; 
            text-transform: uppercase; 
            transition: all 0.3s ease; 
        }
        .size-options input[type="radio"]:checked + label { 
            border-color: var(--emerald); 
            background: var(--emerald); 
            color: var(--off-white); 
        }
    </style>
</head>
<body>

<header class="site-header">
    <div class="container nav-flex">
        
        <a href="<?= e(base_url('index.php')) ?>" class="brand-logo">
            <img src="<?= e(base_url('assets/images/logo.png')) ?>" alt="Ayana Boutique Logo" style="height: 95px; width: auto;">
            <span>Ayana Boutique</span>
        </a>
        
        <nav class="nav-links">
            <a href="<?= e(base_url('categories.php')) ?>">Shop</a>
            <a href="<?= e(base_url('about.php')) ?>">Our Story</a>
            <a href="<?= e(base_url('cart.php')) ?>">Cart (<?= cart_count_total() ?>)</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="<?= e(base_url('account.php')) ?>" style="color: var(--emerald);">Account</a>
            <?php else: ?>
                <a href="<?= e(base_url('login.php')) ?>" style="color: var(--rose-gold);">Sign In</a>
            <?php endif; ?>
        </nav>
    </div>
</header>