<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="alternate" hreflang="es" href="<?php echo esc_url(get_permalink()); ?>" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="site-header" class="site-header">
    <div class="header-container">
        <!-- Logo -->
        <div class="site-branding">
            <a href="<?php echo home_url(); ?>" class="site-logo">
                <i class="fas fa-tv"></i>
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
                'fallback_cb' => 'simpsons_fallback_menu'
            ));
            ?>
        </nav>

        <!-- Buscador -->
        <div class="header-search">
            <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                <input type="search" class="search-input" placeholder="Buscar capítulos..." name="s" value="<?php echo get_search_query(); ?>">
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
            'fallback_cb' => 'simpsons_fallback_menu'
        ));
        ?>
    </nav>
</header>

<main id="main-content" class="site-content">

