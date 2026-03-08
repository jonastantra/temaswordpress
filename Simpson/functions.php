<?php
/**
 * Theme Name: Simpsons Online Pro
 * Description: Tema personalizado para Los Simpsons Online
 * Version: 1.0.0
 * Text Domain: simpsons-online
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) exit;

/**
 * Configuración del tema
 */
function simpsons_setup() {
    // Soporte para título dinámico
    add_theme_support('title-tag');
    
    // Soporte para imágenes destacadas
    add_theme_support('post-thumbnails');
    
    // Tamaños de imagen personalizados
    add_image_size('episode-thumb', 400, 225, true); // 16:9 ratio
    add_image_size('episode-large', 1280, 720, true); // Full HD 16:9
    add_image_size('episode-featured', 800, 450, true); // Featured size
    
    // Soporte HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Feed automático
    add_theme_support('automatic-feed-links');
    
    // Registrar menús
    register_nav_menus(array(
        'primary' => __('Menú Principal', 'simpsons-online'),
        'footer'  => __('Menú Footer', 'simpsons-online'),
    ));
}
add_action('after_setup_theme', 'simpsons_setup');

/**
 * Cargar estilos y scripts SUPER OPTIMIZADOS
 */
function simpsons_enqueue_assets() {
    // Google Fonts OPTIMIZADO
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Bangers&display=swap',
        array(),
        null
    );
    wp_style_add_data('google-fonts', 'media', 'print');
    wp_add_inline_script('wp-footer', 'document.querySelector("link[href*=\'fonts.googleapis.com\']").media=\'all\';', 'before');
    
    // Font Awesome SUBSET
    wp_enqueue_style(
        'font-awesome-subset',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css',
        array(),
        '6.4.0'
    );
    wp_enqueue_style(
        'font-awesome-solid',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/solid.min.css',
        array('font-awesome-subset'),
        '6.4.0'
    );
    wp_style_add_data('font-awesome-subset', 'media', 'print');
    wp_style_add_data('font-awesome-solid', 'media', 'print');
    
    // Style.css del tema
    wp_enqueue_style(
        'simpsons-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );
    
    // JavaScript principal con defer
    wp_enqueue_script(
        'simpsons-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
    wp_script_add_data('simpsons-main', 'defer', true);
    
    // Inline script para activar Font Awesome
    wp_add_inline_script(
        'simpsons-main',
        'document.querySelectorAll("link[href*=\'fontawesome\']").forEach(l=>l.media="all");',
        'after'
    );
}
add_action('wp_enqueue_scripts', 'simpsons_enqueue_assets');

/**
 * Agregar preconnect para recursos externos
 */
function simpsons_add_resource_hints($hints, $relation_type) {
    if ('preconnect' === $relation_type) {
        $hints[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin',
        );
        $hints[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
        $hints[] = array(
            'href' => 'https://cdnjs.cloudflare.com',
            'crossorigin',
        );
    }
    
    if ('dns-prefetch' === $relation_type) {
        $hints[] = 'https://fonts.googleapis.com';
        $hints[] = 'https://fonts.gstatic.com';
        $hints[] = 'https://cdnjs.cloudflare.com';
    }
    
    return $hints;
}
add_filter('wp_resource_hints', 'simpsons_add_resource_hints', 10, 2);

/**
 * Registrar áreas de widgets
 */
function simpsons_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar Episodios', 'simpsons-online'),
        'id'            => 'sidebar-episodes',
        'description'   => __('Aparece en las páginas de episodios individuales', 'simpsons-online'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    for ($i = 1; $i <= 3; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('Footer Widget %d', 'simpsons-online'), $i),
            'id'            => 'footer-' . $i,
            'description'   => sprintf(__('Área de widget %d del footer', 'simpsons-online'), $i),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
        ));
    }
}
add_action('widgets_init', 'simpsons_widgets_init');

/**
 * Verificar si ACF está activo
 */
function simpsons_check_acf() {
    if (!function_exists('get_field')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-warning"><p>';
            echo '<strong>Simpsons Online Pro:</strong> Este tema requiere el plugin Advanced Custom Fields (ACF) para funcionar correctamente. ';
            echo '<a href="' . admin_url('plugin-install.php?s=advanced+custom+fields&tab=search&type=term') . '">Instalar ACF</a>';
            echo '</p></div>';
        });
    }
}
add_action('admin_init', 'simpsons_check_acf');

/**
 * Mejorar el excerpt
 */
function simpsons_custom_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'simpsons_custom_excerpt_length');

function simpsons_custom_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'simpsons_custom_excerpt_more');

/**
 * Agregar clases personalizadas al body
 */
function simpsons_body_classes($classes) {
    if (is_single()) {
        $classes[] = 'single-episode';
    }
    if (is_archive() || is_category()) {
        $classes[] = 'episodes-archive';
    }
    return $classes;
}
add_filter('body_class', 'simpsons_body_classes');

/**
 * Optimización: Remover versiones de scripts/styles
 */
function simpsons_remove_version_strings($src) {
    global $wp_version;
    parse_str(parse_url($src, PHP_URL_QUERY), $query);
    if (!empty($query['ver']) && $query['ver'] === $wp_version) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('script_loader_src', 'simpsons_remove_version_strings');
add_filter('style_loader_src', 'simpsons_remove_version_strings');

/**
 * Agregar Schema.org completo para videos - LOS SIMPSONS
 * Optimizado con keywords específicas de Los Simpsons
 */
function simpsons_add_video_schema() {
    if (is_single()) {
        global $post;
        $categories = get_the_category();
        $category_name = !empty($categories) ? $categories[0]->name : 'Los Simpsons';
        
        // Obtener thumbnail
        $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'full');
        if (!$thumbnail_url) {
            $thumbnail_url = get_template_directory_uri() . '/assets/images/default-thumbnail.jpg';
        }
        
        // Descripción optimizada para Los Simpsons
        $description = get_the_excerpt();
        if (!$description) {
            $description = 'Ver ' . get_the_title() . ' online en español latino. Disfruta de Los Simpsons y todas las temporadas completas gratis.';
        }
        
        // Duración episodio Los Simpsons (22 minutos típico)
        $duration = 'PT22M';
        
        // Keywords de Los Simpsons
        $keywords = array('Los Simpsons online', 'ver Los Simpsons', 'Simpsons español latino', 'capítulos Simpsons');
        
        // Detectar temporada si está en el título
        $title_lower = strtolower(get_the_title());
        if (preg_match('/temporada (\d+)/i', $title_lower, $matches)) {
            $season = $matches[1];
            $keywords[] = 'Los Simpsons temporada ' . $season;
        }
        
        // Personajes populares keywords
        $keywords[] = 'Homer Simpson';
        $keywords[] = 'Bart Simpson';
        $keywords[] = 'Springfield';
        
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'VideoObject',
            'name' => get_the_title(),
            'description' => $description,
            'thumbnailUrl' => array($thumbnail_url),
            'uploadDate' => get_the_date('c'),
            'duration' => $duration,
            'contentUrl' => get_permalink(),
            'embedUrl' => get_permalink(),
            'keywords' => implode(', ', $keywords),
            'about' => array(
                '@type' => 'Thing',
                'name' => 'Los Simpsons',
                'description' => 'Serie animada creada por Matt Groening'
            ),
            'actor' => array(
                array('@type' => 'Person', 'name' => 'Homer Simpson'),
                array('@type' => 'Person', 'name' => 'Marge Simpson'),
                array('@type' => 'Person', 'name' => 'Bart Simpson'),
                array('@type' => 'Person', 'name' => 'Lisa Simpson'),
                array('@type' => 'Person', 'name' => 'Maggie Simpson')
            ),
            'interactionStatistic' => array(
                '@type' => 'InteractionCounter',
                'interactionType' => array('@type' => 'WatchAction'),
                'userInteractionCount' => get_post_meta($post->ID, 'views_count', true) ?: 0
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => get_site_icon_url()
                )
            ),
            'genre' => array('Comedia', 'Animación', 'Sitcom', $category_name),
            'inLanguage' => 'es-ES',
            'isFamilyFriendly' => true,
            'creator' => array(
                '@type' => 'Person',
                'name' => 'Matt Groening'
            ),
            'productionCompany' => array(
                '@type' => 'Organization',
                'name' => 'Fox Broadcasting Company'
            ),
            'potentialAction' => array(
                '@type' => 'WatchAction',
                'target' => get_permalink()
            )
        );
        
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>';
    }
}
add_action('wp_head', 'simpsons_add_video_schema');

/**
 * Meta tags optimizados para LOS SIMPSONS SEO
 */
function simpsons_add_meta_tags() {
    // Keywords generales de Los Simpsons
    $keywords = array(
        'Los Simpsons online',
        'ver Los Simpsons',
        'Simpsons capítulos',
        'Los Simpsons temporadas',
        'Simpsons español latino',
        'capitulos Simpsons completos',
        'Homer Simpson',
        'Bart Simpson',
        'Marge Simpson',
        'Lisa Simpson',
        'Springfield',
        'Matt Groening',
        'Los Simpsons gratis',
        'ver Simpsons HD'
    );
    
    if (is_single()) {
        $title = get_the_title();
        $categories = get_the_category();
        $temporada = !empty($categories) ? $categories[0]->name : 'Los Simpsons';
        
        // Meta descripción optimizada
        $meta_desc = 'Ver ' . $title . ' online en español latino gratis. Los Simpsons completo en HD. Todas las temporadas disponibles.';
        
        echo '<meta name="description" content="' . esc_attr($meta_desc) . '">' . "\n";
        echo '<meta name="keywords" content="' . esc_attr(implode(', ', $keywords)) . ', ' . esc_attr($title) . '">' . "\n";
        
        // Open Graph
        echo '<meta property="og:title" content="' . esc_attr($title) . ' - Los Simpsons Online">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($meta_desc) . '">' . "\n";
        echo '<meta property="og:type" content="video.episode">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
        
        if (has_post_thumbnail()) {
            echo '<meta property="og:image" content="' . esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')) . '">' . "\n";
        }
        
        // Twitter Card
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($meta_desc) . '">' . "\n";
        
    } elseif (is_home() || is_front_page()) {
        $meta_desc = 'Ver Los Simpsons online gratis en español latino. Todas las temporadas completas de Los Simpsons en HD. Disfruta de Homer, Bart, Lisa, Marge y todos los personajes de Springfield.';
        
        echo '<meta name="description" content="' . esc_attr($meta_desc) . '">' . "\n";
        echo '<meta name="keywords" content="' . esc_attr(implode(', ', $keywords)) . '">' . "\n";
        
        // Open Graph
        echo '<meta property="og:title" content="' . esc_attr(get_bloginfo('name')) . ' - Ver Los Simpsons Online Gratis">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($meta_desc) . '">' . "\n";
        echo '<meta property="og:type" content="website">' . "\n";
        
    } elseif (is_category()) {
        $category = get_queried_object();
        $meta_desc = 'Ver todos los capítulos de ' . $category->name . ' de Los Simpsons online en español latino gratis. Episodios completos en HD.';
        
        echo '<meta name="description" content="' . esc_attr($meta_desc) . '">' . "\n";
        echo '<meta name="keywords" content="' . esc_attr($category->name) . ', Los Simpsons, ' . esc_attr(implode(', ', $keywords)) . '">' . "\n";
    }
    
    // Canonical URL - REMOVED to avoid duplication with WordPress core
    // echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '">' . "\n";
}
add_action('wp_head', 'simpsons_add_meta_tags', 5);

/**
 * Breadcrumbs personalizados
 */
function simpsons_breadcrumbs() {
    $separator = ' <i class="fas fa-chevron-right"></i> ';
    $home_title = 'Inicio';
    
    echo '<nav class="breadcrumbs">';
    echo '<a href="' . home_url() . '">' . $home_title . '</a>' . $separator;
    
    if (is_category()) {
        single_cat_title();
    } elseif (is_single()) {
        $categories = get_the_category();
        if ($categories) {
            $category = $categories[0];
            echo '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>' . $separator;
        }
        the_title();
    } elseif (is_page()) {
        the_title();
    } elseif (is_search()) {
        echo 'Resultados de búsqueda: ' . get_search_query();
    } elseif (is_404()) {
        echo 'Error 404';
    }
    
    echo '</nav>';
}

/**
 * Mejorar SEO de títulos - Optimizado para Los Simpsons
 */
function simpsons_wp_title($title) {
    if (is_feed()) {
        return $title;
    }
    
    $site_name = get_bloginfo('name');
    
    if (is_singular()) {
        $categories = get_the_category();
        $temporada = !empty($categories) ? ' - ' . $categories[0]->name : ' - Los Simpsons';
        $title .= $temporada . ' Online - ' . $site_name;
    } elseif (is_category()) {
        $title .= ' - Ver Online en Español Latino';
    } elseif (is_home() || is_front_page()) {
        $title = $site_name . ' - Ver Los Simpsons Online Gratis - Todas las Temporadas';
    }
    
    return $title;
}
add_filter('wp_title', 'simpsons_wp_title');

/**
 * Modificar el título del documento
 */
function simpsons_document_title_parts($title) {
    if (is_singular()) {
        $categories = get_the_category();
        if (!empty($categories)) {
            $title['title'] = get_the_title();
            $title['tagline'] = $categories[0]->name . ' Online';
            $title['site'] = 'Los Simpsons';
        }
    } elseif (is_home() || is_front_page()) {
        $title['title'] = 'Ver Los Simpsons Online';
        $title['tagline'] = 'Todas las Temporadas Completas';
    }
    
    return $title;
}
add_filter('document_title_parts', 'simpsons_document_title_parts');

/**
 * Menú fallback
 */
function simpsons_fallback_menu() {
    echo '<ul class="nav-menu">';
    echo '<li class="current-menu-item"><a href="' . home_url() . '"><i class="fas fa-home"></i> Inicio</a></li>';
    
    $categories = get_categories(array(
        'orderby' => 'count',
        'order' => 'DESC',
        'hide_empty' => true,
        'number' => 6
    ));
    
    foreach ($categories as $category) {
        echo '<li><a href="' . get_category_link($category->term_id) . '">' . esc_html($category->name) . '</a></li>';
    }
    
    echo '</ul>';
}

// INCLUIR TODAS LAS OPTIMIZACIONES AVANZADAS
require_once get_template_directory() . '/inc/optimizations.php';

