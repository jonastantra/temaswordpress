<?php
/**
 * Optimizaciones Avanzadas - Los Simpsons Online
 * Incluye todas las optimizaciones de rendimiento y SEO
 */

if (!defined('ABSPATH')) exit;

/**
 * Deshabilitar emojis de WordPress
 */
function simpsons_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'simpsons_disable_emojis');

/**
 * Remover jQuery Migrate
 */
function simpsons_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'simpsons_remove_jquery_migrate');

/**
 * Defer/Async parsing of JavaScript
 */
function simpsons_defer_parsing_of_js($tag, $handle, $src) {
    if (is_admin()) return $tag;
    
    $no_defer = array('jquery', 'jquery-core', 'jquery-migrate');
    
    if (in_array($handle, $no_defer)) {
        return $tag;
    }
    
    $async_scripts = array('font-awesome', 'google-fonts');
    
    if (in_array($handle, $async_scripts)) {
        return str_replace(' src', ' async src', $tag);
    }
    
    if (strpos($tag, 'defer') === false && strpos($tag, 'async') === false) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'simpsons_defer_parsing_of_js', 10, 3);

/**
 * Deshabilitar WP embeds
 */
function simpsons_disable_embeds() {
    wp_dequeue_script('wp-embed');
}
add_action('wp_footer', 'simpsons_disable_embeds');

/**
 * Remover query strings
 */
function simpsons_remove_query_strings($src) {
    if (strpos($src, '?ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('script_loader_src', 'simpsons_remove_query_strings', 15, 1);
add_filter('style_loader_src', 'simpsons_remove_query_strings', 15, 1);

/**
 * Agregar atributos de carga para imágenes
 */
function simpsons_add_image_attributes($attr) {
    if (!isset($attr['loading'])) {
        $attr['loading'] = 'lazy';
    }
    if (!isset($attr['decoding'])) {
        $attr['decoding'] = 'async';
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'simpsons_add_image_attributes');

/**
 * Contador de vistas
 */
function simpsons_set_post_views($postID) {
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
 * Limitar heartbeat API
 */
function simpsons_optimize_heartbeat($settings) {
    $settings['interval'] = 60;
    return $settings;
}
add_filter('heartbeat_settings', 'simpsons_optimize_heartbeat');

/**
 * Optimizar iframes de video
 */
function simpsons_optimize_iframe($iframe_code) {
    if (empty($iframe_code)) {
        return '';
    }
    
    if (strpos($iframe_code, 'loading=') === false) {
        $iframe_code = str_replace('<iframe', '<iframe loading="lazy"', $iframe_code);
    }
    
    if (strpos($iframe_code, 'importance=') === false) {
        $iframe_code = str_replace('<iframe', '<iframe importance="high"', $iframe_code);
    }
    
    if (strpos($iframe_code, 'allow=') === false) {
        $iframe_code = str_replace('<iframe', '<iframe allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"', $iframe_code);
    }
    
    if (strpos($iframe_code, 'title=') === false) {
        $iframe_code = str_replace('<iframe', '<iframe title="Reproductor de video"', $iframe_code);
    }
    
    return $iframe_code;
}

/**
 * Agregar Cache-Control headers
 */
function simpsons_add_cache_headers() {
    if (!is_admin()) {
        header('Cache-Control: public, max-age=31536000');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
    }
}
add_action('send_headers', 'simpsons_add_cache_headers');

/**
 * Deshabilitar REST API para no autenticados
 */
function simpsons_disable_rest_api($access) {
    if (!is_user_logged_in()) {
        return new WP_Error('rest_disabled', __('La API REST está deshabilitada.', 'simpsons-online'), array('status' => 403));
    }
    return $access;
}
add_filter('rest_authentication_errors', 'simpsons_disable_rest_api');

/**
 * Comprimir HTML output (DESHABILITADO: Rompía Schema JSON-LD de Google)
 */
/*
function simpsons_compress_html() {
    ob_start(function($html) {
        $html = preg_replace('/<!--(?!<!)[^\[>].*?-->/s', '', $html);
        $html = preg_replace('/\s+/', ' ', $html);
        $html = preg_replace('/>\s+</', '><', $html);
        return $html;
    });
}
add_action('get_header', 'simpsons_compress_html');
*/

/**
 * Critical CSS inline
 */
function simpsons_inline_critical_css() {
    ?>
    <style id="critical-css">
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Poppins,sans-serif;background:#1a1a1a;color:#fff;line-height:1.6;overflow-x:hidden}
        img{max-width:100%;height:auto;display:block}
        a{color:#FFD90F;text-decoration:none;transition:all .3s ease}
        a:hover{color:#FF6B35}
        .site-header{position:fixed;top:0;left:0;right:0;z-index:1000;background:rgba(26,26,26,.95);border-bottom:3px solid #FFD90F;backdrop-filter:blur(10px);transition:transform .3s ease,box-shadow .3s ease}
        .site-header.scrolled{box-shadow:0 4px 16px rgba(0,0,0,.4)}
        .header-container{display:flex;align-items:center;justify-content:space-between;padding:1rem 2rem;max-width:1400px;margin:0 auto}
        .site-branding .site-logo{display:flex;align-items:center;gap:.5rem;color:#fff;text-decoration:none;font-size:1.5rem;font-weight:700;font-family:Bangers,cursive;letter-spacing:1px}
        .site-branding .site-logo i{color:#FFD90F;font-size:2rem}
        .site-branding .site-logo:hover{color:#FFD90F}
        .nav-menu{display:flex;list-style:none;gap:.25rem;margin:0;align-items:center;flex-wrap:nowrap}
        .nav-menu>li>a{display:block;padding:.6rem 1rem;color:#fff;font-weight:500;font-size:.95rem;border-radius:6px;transition:all .3s ease;white-space:nowrap}
        .nav-menu>li>a:hover,.nav-menu>li.current-menu-item>a{background:#FFD90F;color:#1a1a1a}
        .mobile-menu-toggle{display:flex;flex-direction:column;gap:4px;background:transparent;border:none;cursor:pointer;padding:.5rem}
        .hamburger-line{width:25px;height:3px;background:#FFD90F;transition:all .3s ease;border-radius:2px}
        .site-content{min-height:100vh;padding-top:80px}
        .container{max-width:1400px;margin:0 auto;padding:0 2rem}
        .video-player-section{background:#2a2a2a;padding:2rem;border-radius:12px;margin-bottom:2rem}
        .video-embed-wrapper{position:relative;padding-bottom:56.25%;height:0;overflow:hidden;background:#000;border-radius:8px}
        .video-embed-wrapper iframe{position:absolute;top:0;left:0;width:100%;height:100%;border:0}
        .player-tabs{display:flex;gap:.5rem;margin-bottom:1rem;flex-wrap:wrap}
        .player-tabs .tab{background:#3a3a3a;border:2px solid transparent;padding:.75rem 1.5rem;border-radius:8px;color:#b0b0b0;cursor:pointer;transition:all .3s ease;display:flex;align-items:center;gap:.5rem;font-weight:600;font-size:.95rem}
        .player-tabs .tab:hover{background:#2a2a2a;border-color:#FFD90F;color:#fff}
        .player-tabs .tab.active{background:#FFD90F;border-color:#FFD90F;color:#1a1a1a;box-shadow:0 4px 12px rgba(255,217,15,.4)}
        .tab-content{display:none;animation:fadeIn .3s ease}
        .tab-content.active{display:block}
        @keyframes fadeIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
        .episode-card{background:#2a2a2a;border-radius:12px;overflow:hidden;transition:all .3s ease;border:2px solid transparent}
        .episode-card:hover{transform:translateY(-8px);border-color:#FFD90F;box-shadow:0 8px 32px rgba(0,0,0,.5)}
        .episode-thumbnail{position:relative;overflow:hidden;aspect-ratio:16/9;background:#1a1a1a}
        .episode-info{padding:1rem}
        .episode-title{font-size:1rem;font-weight:600;margin-bottom:.5rem;color:#fff}
        .saga-badge{position:absolute;top:.5rem;left:.5rem;background:#FFD90F;color:#1a1a1a;padding:.25rem .75rem;border-radius:20px;font-size:.75rem;font-weight:700;text-transform:uppercase;z-index:10}
        .episodes-grid,.episodes-archive-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;padding:2rem}
        .loading-placeholder{background:linear-gradient(90deg,#2a2a2a 25%,#3a3a3a 50%,#2a2a2a 75%);background-size:200% 100%;animation:loading 1.5s infinite}
        @keyframes loading{0%{background-position:200% 0}100%{background-position:-200% 0}}
        @media(max-width:768px){.main-navigation.desktop-menu{display:none}.mobile-menu-toggle{display:flex}}
        @media(max-width:640px){.container{padding:0 1rem}.header-container{padding:1rem}.episodes-grid,.episodes-archive-grid{grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:1rem;padding:1rem}}
    </style>
    <?php
}
add_action('wp_head', 'simpsons_inline_critical_css', 1);

/**
 * Preload de imagen principal
 */
function simpsons_preload_featured_image() {
    if (is_single() && has_post_thumbnail()) {
        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        if ($thumbnail_url) {
            echo '<link rel="preload" as="image" href="' . esc_url($thumbnail_url) . '" fetchpriority="high" />';
        }
    }
}
add_action('wp_head', 'simpsons_preload_featured_image', 1);

/**
 * Prefetch del siguiente episodio
 */
function simpsons_prefetch_next_episode() {
    if (is_single()) {
        $next_post = get_next_post();
        if ($next_post) {
            echo '<link rel="prefetch" href="' . get_permalink($next_post) . '" as="document">';
            
            $next_thumb = get_the_post_thumbnail_url($next_post->ID, 'episode-thumb');
            if ($next_thumb) {
                echo '<link rel="prefetch" href="' . $next_thumb . '" as="image">';
            }
        }
    }
}
add_action('wp_head', 'simpsons_prefetch_next_episode');

/**
 * Loading eager para primera imagen
 */
function simpsons_priority_image_loading($attr, $attachment) {
    if (is_single() && has_post_thumbnail() && $attachment->ID === get_post_thumbnail_id()) {
        $attr['loading'] = 'eager';
        $attr['fetchpriority'] = 'high';
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'simpsons_priority_image_loading', 20, 2);

/**
 * Srcset responsive
 */
function simpsons_add_responsive_images($attr, $attachment, $size) {
    if (!isset($attr['sizes'])) {
        $attr['sizes'] = '(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw';
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'simpsons_add_responsive_images', 10, 3);

/**
 * Preload de fuentes
 */
function simpsons_preload_fonts() {
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
add_action('wp_head', 'simpsons_preload_fonts', 2);

/**
 * Deshabilitar dashicons
 */
function simpsons_dequeue_dashicons() {
    if (!is_user_logged_in()) {
        wp_dequeue_style('dashicons');
        wp_deregister_style('dashicons');
    }
}
add_action('wp_enqueue_scripts', 'simpsons_dequeue_dashicons');

/**
 * Headers de seguridad
 */
function simpsons_add_expires_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
    }
}
add_action('send_headers', 'simpsons_add_expires_headers');

// Deshabilitar XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Remover WP version
remove_action('wp_head', 'wp_generator');

/**
 * Deshabilitar feeds (COMENTADO: Permitimos RSS para ayudar a la indexación rápida de Google)
 */
// function simpsons_disable_feeds() {
//     wp_die(__('No hay feeds disponibles. Por favor visita nuestra <a href="' . home_url('/') . '">página principal</a>.', 'simpsons-online'));
// }
// add_action('do_feed', 'simpsons_disable_feeds', 1);
// add_action('do_feed_rdf', 'simpsons_disable_feeds', 1);
// add_action('do_feed_rss', 'simpsons_disable_feeds', 1);
// add_action('do_feed_rss2', 'simpsons_disable_feeds', 1);
// add_action('do_feed_atom', 'simpsons_disable_feeds', 1);

/**
 * Deshabilitar REST endpoints innecesarios
 */
function simpsons_disable_rest_endpoints($endpoints) {
    if (isset($endpoints['/wp/v2/users'])) {
        unset($endpoints['/wp/v2/users']);
    }
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
}
add_filter('rest_endpoints', 'simpsons_disable_rest_endpoints');

/**
 * Limitar revisiones
 */
function simpsons_limit_post_revisions($num, $post) {
    return 3;
}
add_filter('wp_revisions_to_keep', 'simpsons_limit_post_revisions', 10, 2);

/**
 * Deshabilitar auto-guardado
 */
function simpsons_disable_autosave() {
    if (!is_admin()) {
        wp_deregister_script('autosave');
    }
}
add_action('wp_print_scripts', 'simpsons_disable_autosave');

/**
 * Optimizar consultas
 */
function simpsons_optimize_queries($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_archive() || is_home() || is_front_page()) {
            $query->set('no_found_rows', true);
            $query->set('update_post_meta_cache', false);
            $query->set('update_post_term_cache', false);
        }
    }
}
add_action('pre_get_posts', 'simpsons_optimize_queries');

/**
 * Flush output buffer
 */
function simpsons_flush_output() {
    if (ob_get_level() > 0) {
        ob_end_flush();
    }
}
add_action('wp_footer', 'simpsons_flush_output', 999);

