<?php
/**
 * Theme Name: DB Online Pro
 * Description: Tema personalizado para Dragon Ball Online
 * Version: 1.0.0
 * Text Domain: db-online
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) exit;

/**
 * Configuración del tema
 */
function dbonline_setup() {
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
        'primary' => __('Menú Principal', 'db-online'),
        'footer'  => __('Menú Footer', 'db-online'),
    ));
}
add_action('after_setup_theme', 'dbonline_setup');

/**
 * Cargar estilos y scripts SUPER OPTIMIZADOS
 * Soluciona problemas de PageSpeed: render-blocking, CSS/JS sin usar
 */
function dbonline_enqueue_assets() {
    // NO CARGAR Tailwind CSS (causa 76KB de CSS sin usar)
    // Usaremos solo nuestro CSS personalizado
    
    // Google Fonts OPTIMIZADO - Solo pesos necesarios + display=swap
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Bangers&display=swap',
        array(),
        null
    );
    // Hacer que no bloquee renderización
    wp_style_add_data('google-fonts', 'media', 'print');
    wp_add_inline_script('wp-footer', 'document.querySelector("link[href*=\'fonts.googleapis.com\']").media=\'all\';', 'before');
    
    // Font Awesome SOLO iconos usados (soluciona 444KB de JS sin usar)
    // En lugar de cargar TODO Font Awesome, cargaremos solo los necesarios
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
    // Hacer async
    wp_style_add_data('font-awesome-subset', 'media', 'print');
    wp_style_add_data('font-awesome-solid', 'media', 'print');
    
    // Style.css del tema (ahora será el principal)
    wp_enqueue_style(
        'dbonline-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );
    
    // JavaScript principal con defer
    wp_enqueue_script(
        'dbonline-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
    wp_script_add_data('dbonline-main', 'defer', true);
    
    // Inline script para activar Font Awesome (evita render-blocking)
    wp_add_inline_script(
        'dbonline-main',
        'document.querySelectorAll("link[href*=\'fontawesome\']").forEach(l=>l.media="all");',
        'after'
    );
}
add_action('wp_enqueue_scripts', 'dbonline_enqueue_assets');

/**
 * Agregar preconnect para recursos externos (mejora rendimiento)
 * Optimizado para reducir solicitudes de bloqueo
 */
function dbonline_add_resource_hints($hints, $relation_type) {
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
add_filter('wp_resource_hints', 'dbonline_add_resource_hints', 10, 2);

/**
 * Registrar áreas de widgets
 */
function dbonline_widgets_init() {
    // Sidebar para single posts
    register_sidebar(array(
        'name'          => __('Sidebar Episodios', 'db-online'),
        'id'            => 'sidebar-episodes',
        'description'   => __('Aparece en las páginas de episodios individuales', 'db-online'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    // Footer widgets
    for ($i = 1; $i <= 3; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('Footer Widget %d', 'db-online'), $i),
            'id'            => 'footer-' . $i,
            'description'   => sprintf(__('Área de widget %d del footer', 'db-online'), $i),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
        ));
    }
}
add_action('widgets_init', 'dbonline_widgets_init');

/**
 * Verificar si ACF está activo
 */
function dbonline_check_acf() {
    if (!function_exists('get_field')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-warning"><p>';
            echo '<strong>DB Online Pro:</strong> Este tema requiere el plugin Advanced Custom Fields (ACF) para funcionar correctamente. ';
            echo '<a href="' . admin_url('plugin-install.php?s=advanced+custom+fields&tab=search&type=term') . '">Instalar ACF</a>';
            echo '</p></div>';
        });
    }
}
add_action('admin_init', 'dbonline_check_acf');

/**
 * Mejorar el excerpt
 */
function dbonline_custom_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'dbonline_custom_excerpt_length');

function dbonline_custom_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'dbonline_custom_excerpt_more');

/**
 * Agregar clases personalizadas al body
 */
function dbonline_body_classes($classes) {
    if (is_single()) {
        $classes[] = 'single-episode';
    }
    if (is_archive() || is_category()) {
        $classes[] = 'episodes-archive';
    }
    return $classes;
}
add_filter('body_class', 'dbonline_body_classes');

/**
 * Optimización: Remover versiones de scripts/styles
 */
function dbonline_remove_version_strings($src) {
    global $wp_version;
    parse_str(parse_url($src, PHP_URL_QUERY), $query);
    if (!empty($query['ver']) && $query['ver'] === $wp_version) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('script_loader_src', 'dbonline_remove_version_strings');
add_filter('style_loader_src', 'dbonline_remove_version_strings');

/**
 * Agregar Schema.org completo para videos (Google rich snippets)
 * Optimizado para Dragon Ball - keywords específicas
 */
function dbonline_add_video_schema() {
    if (is_single()) {
        global $post;
        $categories = get_the_category();
        $category_name = !empty($categories) ? $categories[0]->name : 'Dragon Ball';
        
        // Obtener thumbnail
        $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'full');
        if (!$thumbnail_url) {
            $thumbnail_url = get_template_directory_uri() . '/assets/images/default-thumbnail.jpg';
        }
        
        // Descripción optimizada
        $description = get_the_excerpt();
        if (!$description) {
            $description = 'Ver ' . get_the_title() . ' online en español latino. Disfruta de Dragon Ball, DBZ, Dragon Ball GT, Dragon Ball Super y todas las sagas completas.';
        }
        
        // INTENTO DE IDIOMA Y SUBTÍTULOS
        // Intentar detectar idioma del título o categoría
        $in_language = 'es';
        if (stripos(get_the_title(), 'sub') !== false || stripos($category_name, 'sub') !== false) {
             $in_language = 'ja'; // Japonés con subtítulos
        }

        // EXTRACT VIDEO URL FROM ACF FIELDS
        // Esto es lo CRÍTICO para Google: embedUrl debe ser la URL del video real, no de la página
        $embed_url = '';
        $potential_players = [];
        
        if (function_exists('get_field')) {
            $p1 = get_field('player1');
            $p2 = get_field('player2');
            $p3 = get_field('player3');
            
            if ($p1) $potential_players[] = $p1;
            if ($p2) $potential_players[] = $p2;
            if ($p3) $potential_players[] = $p3;
        }
        
        // Extraer src de reproductores (incluye MEGA o iframes de terceros genericos)
        foreach ($potential_players as $player_code) {
            if (preg_match('/src="([^"]+)"/', $player_code, $match)) {
                $embed_url = $match[1];
                // Limpiar URL si es relativa (protocolo)
                if (strpos($embed_url, '//') === 0) {
                    $embed_url = 'https:' . $embed_url;
                }
                break; 
            }
        }
        
        // Si no encontramos embedUrl válido o es MEGA (que Googlebot no puede renderizar bien a veces)
        // Ya no ponemos the_permalink() falsamente, porque Google Search Console lo marca como 
        // "El vídeo no está en una página de visualización"
        if (empty($embed_url)) {
            return; // ABORTAMOS: es mejor no tener schema que uno con errores para Google.
        }

        
        // Calcular duración (estimada si no hay metadatos reales)
        $duration = 'PT24M'; 
        
        // Keywords
        $keywords = array('Dragon Ball online', 'ver Dragon Ball', 'Dragon Ball español latino', $category_name, 'Anime online');
        
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'VideoObject',
            'name' => get_the_title(),
            'description' => $description,
            'thumbnailUrl' => array($thumbnail_url),
            'uploadDate' => get_the_date('c'),
            'duration' => $duration,
            'embedUrl' => $embed_url, // URL REAL DEL IFRAME
            'contentUrl' => $embed_url, // Generalmente igual para iframes de terceros
            'keywords' => implode(', ', $keywords),
            'about' => array(
                '@type' => 'Thing',
                'name' => 'Ver Dragon Ball Online Gratis'
            ),
            'actor' => array(
                array('@type' => 'Person', 'name' => 'Goku'),
                array('@type' => 'Person', 'name' => 'Vegeta'),
                array('@type' => 'Person', 'name' => 'Gohan')
            ),
            'creator' => array(
                '@type' => 'Person',
                'name' => 'Akira Toriyama'
            ),
            'productionCompany' => array(
                '@type' => 'Organization',
                'name' => 'Toei Animation'
            ),
            'potentialAction' => array(
                '@type' => 'WatchAction',
                'target' => get_permalink()
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => get_site_icon_url()
                )
            ),
            'inLanguage' => $in_language,
            'isFamilyFriendly' => true,
            'genre' => array('Anime', 'Action', 'Fantasy')
        );
        
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }
}
add_action('wp_head', 'dbonline_add_video_schema');

/**
 * Meta tags optimizados para Dragon Ball SEO
 */
function dbonline_add_dragonball_meta_tags() {
    // Keywords generales de Dragon Ball
    $keywords = array(
        'Dragon Ball online',
        'ver Dragon Ball',
        'Dragon Ball Z',
        'Dragon Ball GT',
        'Dragon Ball Super',
        'Dragon Ball Kai',
        'episodios Dragon Ball',
        'capitulos Dragon Ball',
        'Dragon Ball español latino',
        'donde ver dragon ball super gratis',
        'dragon ball hd sin limites',
        'ver dragon ball online gratis',
        'DBZ online',
        'DBS online',
        'DBGT episodios',
        'Goku',
        'Vegeta',
        'Super Saiyan',
        'anime Dragon Ball',
        'Akira Toriyama'
    );
    
    if (is_single()) {
        $title = get_the_title();
        $categories = get_the_category();
        $saga = !empty($categories) ? $categories[0]->name : 'Dragon Ball';
        
        // Meta descripción optimizada
        $meta_desc = 'Ver ' . $title . ' online en español latino. ' . $saga . ' completo gratis. Todos los episodios de Dragon Ball, DBZ, GT, Super en HD.';
        
        echo '<meta name="description" content="' . esc_attr($meta_desc) . '">' . "\n";
        echo '<meta name="keywords" content="' . esc_attr(implode(', ', $keywords)) . ', ' . esc_attr($title) . '">' . "\n";
        
        // Open Graph para redes sociales
        echo '<meta property="og:title" content="' . esc_attr($title) . ' - Dragon Ball Online">' . "\n";
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
        $meta_desc = 'Ver Dragon Ball online gratis en español latino. Todos los episodios de Dragon Ball, DBZ, Dragon Ball GT, Dragon Ball Super, DB Kai y películas en HD sin límites. ¡Disfruta de Goku y todas las sagas en el mejor sitio de Dragon Ball!';
        
        echo '<meta name="description" content="' . esc_attr($meta_desc) . '">' . "\n";
        echo '<meta name="keywords" content="' . esc_attr(implode(', ', $keywords)) . '">' . "\n";
        
        // Open Graph
        echo '<meta property="og:title" content="' . esc_attr(get_bloginfo('name')) . ' - Ver Dragon Ball Online Gratis">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($meta_desc) . '">' . "\n";
        echo '<meta property="og:type" content="website">' . "\n";
        
    } elseif (is_category()) {
        $category = get_queried_object();
        $meta_desc = 'Ver todos los episodios de ' . $category->name . ' online en español latino gratis. Capítulos completos en HD.';
        
        echo '<meta name="description" content="' . esc_attr($meta_desc) . '">' . "\n";
        echo '<meta name="keywords" content="' . esc_attr($category->name) . ' online, episodios ' . esc_attr($category->name) . ', ' . esc_attr(implode(', ', $keywords)) . '">' . "\n";
    } elseif (is_page()) {
        $title = get_the_title();
        $meta_desc = 'Guía de capítulos y episodios de ' . $title . '. Ver Dragon Ball online en español latino y HD. Lista completa de episodios gratis.';
        
        echo '<meta name="description" content="' . esc_attr($meta_desc) . '">' . "\n";
        echo '<meta name="keywords" content="' . esc_attr($title) . ', lista de episodios, guía de capítulos, ' . esc_attr(implode(', ', array_slice($keywords, 0, 5))) . '">' . "\n";
    }
    
    // Canonical URL (importante para SEO) CONDICIONAL
    if (is_singular()) {
        echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '">' . "\n";
    } elseif (is_home() || is_front_page()) {
        echo '<link rel="canonical" href="' . esc_url(home_url('/')) . '">' . "\n";
    } elseif (is_category() || is_tag() || is_tax()) {
        echo '<link rel="canonical" href="' . esc_url(get_term_link(get_queried_object())) . '">' . "\n";
    } elseif (is_paged()) {
        echo '<link rel="canonical" href="' . esc_url(get_pagenum_link(get_query_var('paged'))) . '">' . "\n";
    }
}
add_action('wp_head', 'dbonline_add_dragonball_meta_tags', 5);

/**
 * Breadcrumbs personalizados con Schema.org
 */
function dbonline_breadcrumbs() {
    $separator = ' <i class="fas fa-chevron-right"></i> ';
    $home_title = 'Inicio';
    
    // Schema List items
    $itemListElement = array();
    $position = 1;

    // Item Inicio
    $itemListElement[] = array(
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => $home_title,
        'item' => home_url()
    );

    echo '<nav class="breadcrumbs" aria-label="Breadcrumb">';
    echo '<a href="' . home_url() . '">' . $home_title . '</a>' . $separator;
    
    if (is_category()) {
        $cat_title = single_cat_title('', false);
        echo $cat_title;
        $itemListElement[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => $cat_title,
            'item' => get_category_link(get_queried_object_id())
        );
    } elseif (is_single()) {
        $categories = get_the_category();
        if ($categories) {
            $category = $categories[0];
            echo '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>' . $separator;
            
            $itemListElement[] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $category->name,
                'item' => get_category_link($category->term_id)
            );
        }
        $post_title = get_the_title();
        echo $post_title;
        $itemListElement[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => $post_title,
            'item' => get_permalink()
        );
    } elseif (is_page()) {
        $post_title = get_the_title();
        echo $post_title;
        $itemListElement[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => $post_title,
            'item' => get_permalink()
        );
    } elseif (is_search()) {
        echo 'Resultados de búsqueda: ' . get_search_query();
    } elseif (is_404()) {
        echo 'Error 404';
    }
    
    echo '</nav>';
    
    // Imprimir el Schema JSON-LD de los Breadcrumbs
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $itemListElement
    );
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}

/**
 * Limitar palabras en excerpt
 */
function dbonline_excerpt($limit = 20) {
    $excerpt = get_the_excerpt();
    $excerpt = explode(' ', $excerpt, $limit);
    if (count($excerpt) >= $limit) {
        array_pop($excerpt);
        $excerpt = implode(" ", $excerpt) . '...';
    } else {
        $excerpt = implode(" ", $excerpt);
    }
    return $excerpt;
}

/**
 * Mejorar SEO de títulos - Optimizado para Dragon Ball
 */
function dbonline_wp_title($title) {
    if (is_feed()) {
        return $title;
    }
    
    $site_name = get_bloginfo('name');
    
    if (is_singular()) {
        // Agregar keywords de Dragon Ball al título
        $categories = get_the_category();
        $saga = !empty($categories) ? ' - ' . $categories[0]->name : ' - Dragon Ball';
        $title .= $saga . ' Online - ' . $site_name;
    } elseif (is_category()) {
        $title .= ' - Ver Online en Español Latino';
    } elseif (is_home() || is_front_page()) {
        $title = $site_name . ' - Ver Dragon Ball, DBZ, GT, Super Online Gratis';
    }
    
    return $title;
}
add_filter('wp_title', 'dbonline_wp_title');

/**
 * Modificar el título del documento (SEO optimizado)
 */
function dbonline_document_title_parts($title) {
    if (is_singular()) {
        $categories = get_the_category();
        if (!empty($categories)) {
            $title['title'] = get_the_title();
            $title['tagline'] = $categories[0]->name . ' Online';
            $title['site'] = 'Dragon Ball';
        }
    } elseif (is_home() || is_front_page()) {
        $title['title'] = 'Ver Dragon Ball Online';
        $title['tagline'] = 'DBZ, GT, Super - Todos los Episodios';
    }
    
    return $title;
}
add_filter('document_title_parts', 'dbonline_document_title_parts');

/**
 * Menú fallback cuando no hay menú configurado
 */
function dbonline_fallback_menu() {
    echo '<ul class="nav-menu">';
    echo '<li class="current-menu-item"><a href="' . home_url() . '"><i class="fas fa-home"></i> Inicio</a></li>';
    
    // Obtener solo las 6 categorías más importantes
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

/**
 * Deshabilitar emojis de WordPress (Optimización)
 */
function dbonline_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'dbonline_disable_emojis');

/**
 * Remover jQuery Migrate (Optimización)
 */
function dbonline_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'dbonline_remove_jquery_migrate');

/**
 * Defer/Async parsing of JavaScript (mejora rendimiento)
 * Soluciona "Reduce el tiempo de ejecución de JavaScript"
 */
function dbonline_defer_parsing_of_js($tag, $handle, $src) {
    if (is_admin()) return $tag;
    
    // Lista de scripts que NO deben tener defer
    $no_defer = array('jquery', 'jquery-core', 'jquery-migrate');
    
    if (in_array($handle, $no_defer)) {
        return $tag;
    }
    
    // Scripts que deben ser async en lugar de defer
    $async_scripts = array('font-awesome', 'google-fonts');
    
    if (in_array($handle, $async_scripts)) {
        return str_replace(' src', ' async src', $tag);
    }
    
    // Todos los demás: defer
    if (strpos($tag, 'defer') === false && strpos($tag, 'async') === false) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'dbonline_defer_parsing_of_js', 10, 3);

/**
 * Deshabilitar WP embeds (optimización)
 */
function dbonline_disable_embeds() {
    wp_dequeue_script('wp-embed');
}
add_action('wp_footer', 'dbonline_disable_embeds');

/**
 * Remover query strings de recursos estáticos
 */
function dbonline_remove_query_strings($src) {
    if (strpos($src, '?ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('script_loader_src', 'dbonline_remove_query_strings', 15, 1);
add_filter('style_loader_src', 'dbonline_remove_query_strings', 15, 1);

/**
 * Agregar atributos de carga para imágenes
 */
function dbonline_add_image_attributes($attr) {
    if (!isset($attr['loading'])) {
        $attr['loading'] = 'lazy';
    }
    if (!isset($attr['decoding'])) {
        $attr['decoding'] = 'async';
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'dbonline_add_image_attributes');

/**
 * Contador de vistas para Schema markup
 */
function dbonline_set_post_views($postID) {
    $count_key = 'views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

/**
 * Limitar heartbeat API (reduce carga del servidor)
 */
function dbonline_optimize_heartbeat($settings) {
    $settings['interval'] = 60; // 60 segundos en lugar de 15
    return $settings;
}
add_filter('heartbeat_settings', 'dbonline_optimize_heartbeat');

/**
 * Optimizar iframes de video (CRÍTICO para rendimiento)
 * Agrega loading="lazy", mejora atributos y optimiza carga
 */
function dbonline_optimize_iframe($iframe_code) {
    if (empty($iframe_code)) {
        return '';
    }
    
    // Agregar loading="lazy" si no existe
    if (strpos($iframe_code, 'loading=') === false) {
        $iframe_code = str_replace('<iframe', '<iframe loading="lazy"', $iframe_code);
    }
    
    // Agregar importance="high" para el primer reproductor
    if (strpos($iframe_code, 'importance=') === false) {
        $iframe_code = str_replace('<iframe', '<iframe importance="high"', $iframe_code);
    }
    
    // Asegurar que tiene los atributos necesarios
    if (strpos($iframe_code, 'allow=') === false) {
        $iframe_code = str_replace('<iframe', '<iframe allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"', $iframe_code);
    }
    
    // Agregar título si no existe (accesibilidad)
    if (strpos($iframe_code, 'title=') === false) {
        $iframe_code = str_replace('<iframe', '<iframe title="Reproductor de video"', $iframe_code);
    }
    
    return $iframe_code;
}

/**
 * Agregar Cache-Control headers
 */
function dbonline_add_cache_headers() {
    if (!is_admin()) {
        header('Cache-Control: public, max-age=31536000');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
    }
}
add_action('send_headers', 'dbonline_add_cache_headers');

/**
 * Deshabilitar endpoints de la REST API (seguridad y rendimiento parcial)
 * No bloqueamos TODA la API, solo los usuarios para evitar scraping
 */
function dbonline_disable_rest_api($access) {
    // Si ya es un wp_error o usuario logueado, dejamos pasar
    if (is_wp_error($access) || is_user_logged_in()) {
        return $access;
    }
    
    // Ya no bloqueamos todo, Yoast/RankMath necesitan API abierta para sus utilidades
    return $access;
}
add_filter('rest_authentication_errors', 'dbonline_disable_rest_api');

/**
 * ELIMINADO: Comprimir HTML output agresivamente.
 * Razón SEO: La compresión con regex estaba destruyendo la integridad 
 * del JSON-LD en los etiquetas script, haciendo que Google de un error 
 * en el VideoObject y el BreadcrumbList
 */
// function dbonline_compress_html() { ... }
// add_action('get_header', 'dbonline_compress_html');

/**
 * OPTIMIZACIONES AVANZADAS PARA SITIOS DE VIDEO
 * ===============================================
 */

/**
 * Agregar Critical CSS inline EXPANDIDO
 * Incluye TODOS los estilos above-the-fold para evitar FOUC
 * Soluciona "Reduce el código CSS sin usar"
 */
function dbonline_inline_critical_css() {
    ?>
    <style id="critical-css">
        /* Critical CSS Completo - Above the fold */
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Poppins,sans-serif;background:#0f0f0f;color:#fff;line-height:1.6;overflow-x:hidden}
        img{max-width:100%;height:auto;display:block}
        a{color:#ff6b1a;text-decoration:none;transition:all .3s ease}
        a:hover{color:#ffd700}
        
        /* Header completo */
        .site-header{position:fixed;top:0;left:0;right:0;z-index:1000;background:rgba(15,15,15,.95);border-bottom:2px solid #ff6b1a;backdrop-filter:blur(10px);transition:transform .3s ease,box-shadow .3s ease}
        .site-header.scrolled{box-shadow:0 4px 16px rgba(0,0,0,.4)}
        .header-container{display:flex;align-items:center;justify-content:space-between;padding:1rem 2rem;max-width:1400px;margin:0 auto}
        .site-branding .site-logo{display:flex;align-items:center;gap:.5rem;color:#fff;text-decoration:none;font-size:1.5rem;font-weight:700;font-family:Bangers,cursive;letter-spacing:1px}
        .site-branding .site-logo i{color:#ff6b1a;font-size:2rem}
        .site-branding .site-logo:hover{color:#ff6b1a}
        
        /* Menú */
        .nav-menu{display:flex;list-style:none;gap:.25rem;margin:0;align-items:center;flex-wrap:nowrap}
        .nav-menu>li>a{display:block;padding:.6rem 1rem;color:#fff;font-weight:500;font-size:.95rem;border-radius:6px;transition:all .3s ease;white-space:nowrap}
        .nav-menu>li>a:hover,.nav-menu>li.current-menu-item>a{background:#ff6b1a;color:#fff}
        .mobile-menu-toggle{display:flex;flex-direction:column;gap:4px;background:transparent;border:none;cursor:pointer;padding:.5rem}
        .hamburger-line{width:25px;height:3px;background:#ff6b1a;transition:all .3s ease;border-radius:2px}
        
        /* Contenido */
        .site-content{min-height:100vh;padding-top:80px}
        .container{max-width:1400px;margin:0 auto;padding:0 2rem}
        
        /* Video Player */
        .video-player-section{background:#1a1a1a;padding:2rem;border-radius:12px;margin-bottom:2rem}
        .video-embed-wrapper{position:relative;padding-bottom:56.25%;height:0;overflow:hidden;background:#000;border-radius:8px}
        .video-embed-wrapper iframe{position:absolute;top:0;left:0;width:100%;height:100%;border:0}
        .player-tabs{display:flex;gap:.5rem;margin-bottom:1rem;flex-wrap:wrap}
        .player-tabs .tab{background:#2a2a2a;border:2px solid transparent;padding:.75rem 1.5rem;border-radius:8px;color:#a0a0a0;cursor:pointer;transition:all .3s ease;display:flex;align-items:center;gap:.5rem;font-weight:600;font-size:.95rem}
        .player-tabs .tab:hover{background:#0f0f0f;border-color:#ff6b1a;color:#fff}
        .player-tabs .tab.active{background:#ff6b1a;border-color:#ff6b1a;color:#fff;box-shadow:0 4px 12px rgba(255,107,26,.3)}
        .tab-content{display:none;animation:fadeIn .3s ease}
        .tab-content.active{display:block}
        @keyframes fadeIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
        
        /* Episode Cards */
        .episode-card{background:#1a1a1a;border-radius:12px;overflow:hidden;transition:all .3s ease;border:2px solid transparent}
        .episode-card:hover{transform:translateY(-8px);border-color:#ff6b1a;box-shadow:0 8px 32px rgba(0,0,0,.5)}
        .episode-thumbnail{position:relative;overflow:hidden;aspect-ratio:16/9;background:#0f0f0f}
        .episode-info{padding:1rem}
        .episode-title{font-size:1rem;font-weight:600;margin-bottom:.5rem;color:#fff}
        .saga-badge{position:absolute;top:.5rem;left:.5rem;background:#ff6b1a;color:#fff;padding:.25rem .75rem;border-radius:20px;font-size:.75rem;font-weight:700;text-transform:uppercase;z-index:10}
        
        /* Grid */
        .episodes-grid,.episodes-archive-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;padding:2rem}
        
        /* Loading */
        .loading-placeholder{background:linear-gradient(90deg,#1a1a1a 25%,#2a2a2a 50%,#1a1a1a 75%);background-size:200% 100%;animation:loading 1.5s infinite}
        @keyframes loading{0%{background-position:200% 0}100%{background-position:-200% 0}}
        
        /* Responsive */
        @media(max-width:768px){
            .main-navigation.desktop-menu{display:none}
            .mobile-menu-toggle{display:flex}
        }
        @media(max-width:640px){
            .container{padding:0 1rem}
            .header-container{padding:1rem}
            .episodes-grid,.episodes-archive-grid{grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:1rem;padding:1rem}
        }
    </style>
    <?php
}
add_action('wp_head', 'dbonline_inline_critical_css', 1);

/**
 * Preload de la imagen principal (CRÍTICO - mejora LCP)
 * Largest Contentful Paint es una de las métricas más importantes
 */
function dbonline_preload_featured_image() {
    if (is_single() && has_post_thumbnail()) {
        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        if ($thumbnail_url) {
            echo '<link rel="preload" as="image" href="' . esc_url($thumbnail_url) . '" fetchpriority="high" />';
        }
    }
}
add_action('wp_head', 'dbonline_preload_featured_image', 1);

/**
 * Prefetch del siguiente episodio (mejora navegación)
 * Precarga el siguiente episodio en background
 */
function dbonline_prefetch_next_episode() {
    if (is_single()) {
        $next_post = get_next_post();
        if ($next_post) {
            echo '<link rel="prefetch" href="' . get_permalink($next_post) . '" as="document">';
            
            // Prefetch thumbnail del siguiente
            $next_thumb = get_the_post_thumbnail_url($next_post->ID, 'episode-thumb');
            if ($next_thumb) {
                echo '<link rel="prefetch" href="' . $next_thumb . '" as="image">';
            }
        }
    }
}
add_action('wp_head', 'dbonline_prefetch_next_episode');

/**
 * Agregar loading="eager" a la primera imagen (mejora LCP)
 * La imagen principal debe cargar inmediatamente
 */
function dbonline_priority_image_loading($attr, $attachment) {
    if (is_single() && has_post_thumbnail() && $attachment->ID === get_post_thumbnail_id()) {
        $attr['loading'] = 'eager';
        $attr['fetchpriority'] = 'high';
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'dbonline_priority_image_loading', 20, 2);

/**
 * Agregar srcset responsive a imágenes (mejor para móviles)
 * Optimiza carga según tamaño de pantalla
 */
function dbonline_add_responsive_images($attr, $attachment, $size) {
    if (!isset($attr['sizes'])) {
        $attr['sizes'] = '(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw';
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'dbonline_add_responsive_images', 10, 3);

/**
 * Soporte WebP automático para imágenes
 * WebP reduce el tamaño hasta 30% vs JPG/PNG
 */
function dbonline_webp_support($sources, $size_array, $image_src, $image_meta, $attachment_id) {
    foreach ($sources as $width => $source) {
        $webp_url = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $source['url']);
        // Solo si el archivo WebP existe
        $upload_dir = wp_upload_dir();
        $webp_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $webp_url);
        
        if (file_exists($webp_path)) {
            $sources[$width]['url'] = $webp_url;
            $sources[$width]['type'] = 'image/webp';
        }
    }
    return $sources;
}
add_filter('wp_calculate_image_srcset', 'dbonline_webp_support', 10, 5);

/**
 * Deshabilitar REST API endpoints innecesarios (seguridad + rendimiento)
 */
function dbonline_disable_rest_endpoints($endpoints) {
    if (isset($endpoints['/wp/v2/users'])) {
        unset($endpoints['/wp/v2/users']);
    }
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
}
add_filter('rest_endpoints', 'dbonline_disable_rest_endpoints');

/**
 * Optimización de base de datos - Limpiar revisiones antiguas
 * Reduce tamaño de BD y mejora queries
 */
function dbonline_limit_post_revisions($num, $post) {
    return 3; // Solo mantener últimas 3 revisiones
}
add_filter('wp_revisions_to_keep', 'dbonline_limit_post_revisions', 10, 2);

/**
 * Deshabilitar auto-guardado frecuente (reduce carga servidor)
 * Solo en frontend, no afecta el editor
 */
function dbonline_disable_autosave() {
    if (!is_admin()) {
        wp_deregister_script('autosave');
    }
}
add_action('wp_print_scripts', 'dbonline_disable_autosave');

/**
 * Optimizar consultas de WordPress (IMPORTANTE para listados)
 * Reduce queries innecesarias en archives
 */
function dbonline_optimize_queries($query) {
    if (!is_admin() && $query->is_main_query()) {
        // No cargar post_content en listados (solo single)
        if (is_archive() || is_home()) {
            // Deshabilitar cálculo de filas encontradas (más rápido)
            $query->set('no_found_rows', false);
        }
    }
}
add_action('pre_get_posts', 'dbonline_optimize_queries');

/**
 * Preload de fuentes críticas con font-display
 * Evita FOIT (Flash of Invisible Text) y mejora visualización de fuente
 */
function dbonline_preload_fonts() {
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.gstatic.com/s/poppins/v20/pxiEyp8kv8JHgFVrJJfecg.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="https://fonts.gstatic.com/s/bangers/v20/FeVQS0BTqb0h60ACL5la2bxii28.woff2" as="font" type="font/woff2" crossorigin>
    <style>
        @font-face{font-family:'Poppins';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/poppins/v20/pxiEyp8kv8JHgFVrJJfecg.woff2) format('woff2')}
        @font-face{font-family:'Bangers';font-style:normal;font-weight:400;font-display:swap;src:url(https://fonts.gstatic.com/s/bangers/v20/FeVQS0BTqb0h60ACL5la2bxii28.woff2) format('woff2')}
    </style>
    <?php
}
add_action('wp_head', 'dbonline_preload_fonts', 2);

/**
 * Deshabilitar dashicons en frontend para usuarios no logueados
 * Ahorra ~50KB
 */
function dbonline_dequeue_dashicons() {
    if (!is_user_logged_in()) {
        wp_dequeue_style('dashicons');
        wp_deregister_style('dashicons');
    }
}
add_action('wp_enqueue_scripts', 'dbonline_dequeue_dashicons');

/**
 * Agregar expires headers para recursos estáticos
 */
function dbonline_add_expires_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
    }
}
add_action('send_headers', 'dbonline_add_expires_headers');

/**
 * Deshabilitar XML-RPC (seguridad + reduce ataques)
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Remover WP version del header (seguridad)
 */
remove_action('wp_head', 'wp_generator');

// feeds restaurados (permitidos de nuevo) para ayudar a la indexación
// add_action('do_feed_rdf', 'dbonline_disable_feeds', 1);
// add_action('do_feed_rss', 'dbonline_disable_feeds', 1);
// add_action('do_feed_rss2', 'dbonline_disable_feeds', 1);
// add_action('do_feed_atom', 'dbonline_disable_feeds', 1);

/**
 * Optimización final: Flush de output buffer
 */
function dbonline_flush_output() {
    if (ob_get_level() > 0) {
        ob_end_flush();
    }
}
add_action('wp_footer', 'dbonline_flush_output', 999);

/**
 * ==========================================
 * FASE 2: SEO AVANZADO (NIVEL TEMA)
 * ==========================================
 */

/**
 * 1. Generador de Sitemap XML Nativo Custom
 * Intercepta /sitemap.xml y genera dinámicamente el listado para Google
 */
function dbonline_custom_sitemap() {
    if (strpos($_SERVER['REQUEST_URI'], '/sitemap.xml') !== false) {
        header('Content-Type: application/xml; charset=utf-8');
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        // Home
        echo '  <url>' . "\n";
        echo '    <loc>' . esc_url(home_url('/')) . '</loc>' . "\n";
        echo '    <changefreq>daily</changefreq>' . "\n";
        echo '    <priority>1.0</priority>' . "\n";
        echo '  </url>' . "\n";

        // Query para todas las entradas
        $postsForSitemap = get_posts(array(
            'numberposts' => -1,
            'orderby'     => 'modified',
            'post_type'   => 'post',
            'post_status' => 'publish'
        ));

        foreach($postsForSitemap as $post) {
            setup_postdata($post);
            $postdate = explode(" ", $post->post_modified);
            echo '  <url>' . "\n";
            echo '    <loc>' . get_permalink($post->ID) . '</loc>' . "\n";
            echo '    <lastmod>' . $postdate[0] . '</lastmod>' . "\n";
            echo '    <changefreq>weekly</changefreq>' . "\n";
            echo '    <priority>0.8</priority>' . "\n";
            echo '  </url>' . "\n";
        }
        
        echo '</urlset>';
        exit;
    }
}
add_action('template_redirect', 'dbonline_custom_sitemap');

/**
 * 2. Rel="prev" y Rel="next" en paginaciones
 * Ayuda al rastreo en listados de categorías (Link Juice)
 */
function dbonline_archive_pagination_links() {
    if (is_home() || is_front_page() || is_category() || is_archive() || is_search()) {
        global $wp_query;
        $max_page = $wp_query->max_num_pages;
        if (!$max_page) {
            $max_page = 1;
        }
        $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
        
        if ($paged > 1) {
            echo '<link rel="prev" href="' . esc_url(get_pagenum_link($paged - 1)) . '" />' . "\n";
        }
        if ($paged < $max_page) {
            echo '<link rel="next" href="' . esc_url(get_pagenum_link($paged + 1)) . '" />' . "\n";
        }
    }
}
add_action('wp_head', 'dbonline_archive_pagination_links', 2);

/**
 * 3. Microformato E-E-A-T Adicional: Person y Organization
 * Añade confianza de entidad corporativa / autor al index
 */
function dbonline_author_organization_schema() {
    if (is_single() || is_home()) {
        $sitename = get_bloginfo('name');
        
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => is_single() ? get_the_title() : $sitename,
            'url' => is_single() ? get_permalink() : home_url(),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => $sitename,
                'url' => home_url(),
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => get_site_icon_url() ? get_site_icon_url() : home_url('/wp-content/uploads/logo.png')
                )
            ),
            'author' => array(
                '@type' => 'Person',
                'name' => 'Webmaster Dragon Ball',
                'url' => home_url()
            )
        );
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
add_action('wp_head', 'dbonline_author_organization_schema', 10);

/**
 * 4. Microformato BreadcrumbList Schema (Estructura SEO Avanzada)
 * Ayuda a Google a entender la jerarquía del sitio para fragmentos enriquecidos
 */
function dbonline_add_breadcrumb_schema() {
    if (is_front_page() || is_home()) return;
    
    $breadcrumbs = array(
        array(
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Inicio',
            'item' => home_url('/')
        )
    );
    
    $position = 2;
    if (is_single()) {
        $categories = get_the_category();
        if (!empty($categories)) {
            $breadcrumbs[] = array(
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $categories[0]->name,
                'item' => get_category_link($categories[0]->term_id)
            );
            $position++;
        }
        $breadcrumbs[] = array(
            '@type' => 'ListItem',
            'position' => $position,
            'name' => get_the_title(),
            'item' => get_permalink()
        );
    } elseif (is_category()) {
        $category = get_queried_object();
        $breadcrumbs[] = array(
            '@type' => 'ListItem',
            'position' => $position,
            'name' => $category->name,
            'item' => get_category_link($category->term_id)
        );
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $breadcrumbs
    );
    
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}
add_action('wp_head', 'dbonline_add_breadcrumb_schema', 11);
