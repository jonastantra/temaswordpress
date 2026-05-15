<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Declarar segmento de audiencia (Hreflang) -->
    <link rel="alternate" hreflang="es" href="<?php echo esc_url(home_url($_SERVER['REQUEST_URI'] ?? '/')); ?>" />
    <link rel="alternate" hreflang="x-default" href="<?php echo esc_url(home_url($_SERVER['REQUEST_URI'] ?? '/')); ?>" />
    <link rel="alternate" hreflang="es-419" href="<?php echo esc_url(home_url($_SERVER['REQUEST_URI'] ?? '/')); ?>" />
    
    <?php
    // SEO: Canonical URL
    echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '" />' . "\n";
    
    // Open Graph y Twitter Cards
    if (is_single()) {
        $title = get_the_title();
        $description = get_the_excerpt() ?: 'Ver ' . get_the_title() . ' online en español latino. Dragon Ball, DBZ, GT, Super en HD.';
        $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large') ?: '';
        $url = get_permalink();
        $site_name = get_bloginfo('name');
        $categories = get_the_category();
        $series_name = !empty($categories) ? $categories[0]->name : 'Dragon Ball';
        
        // Open Graph
        echo '<meta property="og:type" content="video.episode" />' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($title) . '" />' . "\n";
        echo '<meta property="og:description" content="' . esc_attr(wp_strip_all_tags($description)) . '" />' . "\n";
        echo '<meta property="og:url" content="' . esc_url($url) . '" />' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '" />' . "\n";
        if ($thumbnail) {
            echo '<meta property="og:image" content="' . esc_url($thumbnail) . '" />' . "\n";
            echo '<meta property="og:image:secure_url" content="' . esc_url($thumbnail) . '" />' . "\n";
            echo '<meta property="og:image:type" content="image/jpeg" />' . "\n";
        }
        echo '<meta property="og:locale" content="es_LA" />' . "\n";
        
        // Video-specific OG
        echo '<meta property="og:video" content="' . esc_url($url) . '" />' . "\n";
        echo '<meta property="og:video:type" content="application/x-shockwave-flash" />' . "\n";
        echo '<meta property="og:video:width" content="1280" />' . "\n";
        echo '<meta property="og:video:height" content="720" />' . "\n";
        
        // Twitter Card
        echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($title) . '" />' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr(wp_strip_all_tags($description)) . '" />' . "\n";
        if ($thumbnail) {
            echo '<meta name="twitter:image" content="' . esc_url($thumbnail) . '" />' . "\n";
        }
        echo '<meta name="twitter:site" content="@dbhdsinlimites" />' . "\n";
        
    } elseif (is_home() || is_front_page()) {
        $title = get_bloginfo('name') . ' - Ver Dragon Ball Online';
        $description = get_bloginfo('description') ?: 'Ver todos los episodios de Dragon Ball, DBZ, GT, Super y Kai en español latino online gratis.';
        $url = home_url('/');
        
        echo '<meta property="og:title" content="' . esc_attr($title) . '" />' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta property="og:url" content="' . esc_url($url) . '" />' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '" />' . "\n";
        echo '<meta property="og:type" content="website" />' . "\n";
        echo '<meta property="og:locale" content="es_LA" />' . "\n";
        
        echo '<meta name="twitter:card" content="summary" />' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($title) . '" />' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($description) . '" />' . "\n";
    }
    ?>
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="site-header" class="site-header">
    <div class="header-container">
        <!-- Logo -->
        <div class="site-branding">
            <a href="<?php echo home_url(); ?>" class="site-logo">
                <i class="fas fa-dragon"></i>
                <span class="site-title"><?php bloginfo('name'); ?></span>
            </a>
        </div>

        <!-- Menú de Navegación Desktop -->
        <nav class="main-navigation desktop-menu">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'nav-menu',
                'container' => false,
                'depth' => 2,
                'fallback_cb' => 'dbonline_fallback_menu'
            ));
            ?>
        </nav>

        <!-- Buscador -->
        <div class="header-search">
            <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                <input type="search" class="search-input" placeholder="Buscar episodios..." name="s" value="<?php echo get_search_query(); ?>">
                <button type="submit" class="search-submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Botón Menú Móvil -->
        <button class="mobile-menu-toggle" aria-label="Menú">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>
    </div>

    <!-- Menú Móvil -->
    <nav class="mobile-navigation">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_class' => 'mobile-menu',
            'container' => false,
            'depth' => 2,
            'fallback_cb' => 'dbonline_fallback_menu'
        ));
        ?>
    </nav>
</header>

<main id="main-content" class="site-content">

