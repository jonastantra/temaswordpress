<?php
/**
 * Single Post Template - Página Individual de Episodio
 * ARCHIVO MÁS IMPORTANTE - Contiene el reproductor de video
 */

get_header(); ?>

<div class="container" style="padding: 2rem;">
    
    <?php while (have_posts()) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class('episode-single'); ?>>
            
            <!-- Breadcrumbs -->
            <?php dbonline_breadcrumbs(); ?>
            
            <!-- Header del Episodio -->
            <header class="episode-header">
                <h1><?php the_title(); ?></h1>
                <div class="episode-meta">
                    <?php 
                    $categories = get_the_category();
                    if (!empty($categories)) :
                    ?>
                        <span class="saga-badge" style="position: static; margin-right: 1rem;">
                            <?php echo esc_html($categories[0]->name); ?>
                        </span>
                    <?php endif; ?>
                    <span class="episode-date" style="color: var(--color-text-muted);">
                        <i class="far fa-calendar"></i>
                        <?php echo get_the_date(); ?>
                    </span>
                </div>
            </header>
            
            <!-- REPRODUCTOR DE VIDEO -->
            <div class="video-player-section">
                <div class="video-player-container">
                    <?php
                    // Contar vista para analytics
                    dbonline_set_post_views(get_the_ID());
                    
                    // Obtener campos personalizados de ACF
                    $player1 = function_exists('get_field') ? get_field('player1') : '';
                    $player2 = function_exists('get_field') ? get_field('player2') : '';
                    $player3 = function_exists('get_field') ? get_field('player3') : '';
                    
                    // Optimizar iframes: agregar loading="lazy" y otros atributos
                    $player1 = dbonline_optimize_iframe($player1);
                    $player2 = dbonline_optimize_iframe($player2);
                    $player3 = dbonline_optimize_iframe($player3);
                    ?>

                    <?php if ($player1 || $player2 || $player3) : ?>
                        
                        <!-- Pestañas de Opciones -->
                        <div class="player-tabs-wrapper">
                            <div class="player-tabs">
                                <button class="tab active" onclick="openTab(event, 'option1')">
                                    <i class="fas fa-play-circle"></i> Opción 1
                                </button>
                                <?php if ($player2) : ?>
                                    <button class="tab" onclick="openTab(event, 'option2')">
                                        <i class="fas fa-play-circle"></i> Opción 2
                                    </button>
                                <?php endif; ?>
                                <?php if ($player3) : ?>
                                    <button class="tab" onclick="openTab(event, 'option3')">
                                        <i class="fas fa-play-circle"></i> Opción 3
                                    </button>
                                <?php endif; ?>
                            </div>

                            <!-- Contenido del Reproductor Opción 1 -->
                            <div id="option1" class="tab-content active">
                                <?php if ($player1) : ?>
                                    <div class="video-embed-wrapper">
                                        <?php echo $player1; ?>
                                    </div>
                                <?php else : ?>
                                    <div class="no-player-message">
                                        <i class="fas fa-video-slash"></i>
                                        <p>Reproductor no disponible</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Contenido del Reproductor Opción 2 -->
                            <?php if ($player2) : ?>
                                <div id="option2" class="tab-content">
                                    <div class="video-embed-wrapper">
                                        <?php echo $player2; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Contenido del Reproductor Opción 3 -->
                            <?php if ($player3) : ?>
                                <div id="option3" class="tab-content">
                                    <div class="video-embed-wrapper">
                                        <?php echo $player3; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                    <?php else : ?>
                        <div class="no-player-available">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>Este episodio aún no tiene reproductores disponibles.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Navegación entre Episodios (Anterior/Siguiente) -->
            <nav class="episode-navigation">
                <div class="nav-buttons">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    ?>
                    
                    <?php if ($prev_post) : ?>
                        <a href="<?php echo get_permalink($prev_post); ?>" class="nav-button prev-episode">
                            <i class="fas fa-chevron-left"></i>
                            <div class="nav-info">
                                <span class="nav-label">Episodio Anterior</span>
                                <span class="nav-title"><?php echo get_the_title($prev_post); ?></span>
                            </div>
                        </a>
                    <?php endif; ?>

                    <?php if ($next_post) : ?>
                        <a href="<?php echo get_permalink($next_post); ?>" class="nav-button next-episode">
                            <div class="nav-info">
                                <span class="nav-label">Siguiente Episodio</span>
                                <span class="nav-title"><?php echo get_the_title($next_post); ?></span>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </nav>
            
            <!-- Descripción/Sinopsis del Episodio -->
            <?php if (get_the_content()) : ?>
                <div class="episode-description">
                    <h2>Sinopsis del Episodio</h2>
                    <div class="episode-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Episodios Relacionados (Misma Saga) -->
            <section class="related-episodes">
                <h2>Más Episodios de Esta Saga</h2>
                <div class="episodes-grid">
                    <?php
                    // Query para obtener posts de la misma categoría
                    $categories = get_the_category();
                    if ($categories) {
                        $category_id = $categories[0]->term_id;
                        $related_args = array(
                            'cat' => $category_id,
                            'post__not_in' => array(get_the_ID()),
                            'posts_per_page' => 6,
                            'orderby' => 'date',
                            'order' => 'DESC'
                        );
                        $related_query = new WP_Query($related_args);
                        
                        if ($related_query->have_posts()) :
                            while ($related_query->have_posts()) : $related_query->the_post();
                                ?>
                                <article class="episode-card">
                                    <a href="<?php the_permalink(); ?>">
                                        <div class="episode-thumbnail">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <?php the_post_thumbnail('episode-thumb'); ?>
                                            <?php else : ?>
                                                <div class="no-thumbnail">
                                                    <i class="fas fa-video"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="episode-info">
                                            <h3 class="episode-title"><?php the_title(); ?></h3>
                                            <span class="episode-date" style="font-size: 0.85rem;">
                                                <i class="far fa-calendar"></i>
                                                <?php echo get_the_date(); ?>
                                            </span>
                                        </div>
                                    </a>
                                </article>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            ?>
                            <p style="grid-column: 1 / -1; text-align: center; color: var(--color-text-muted);">
                                No hay episodios relacionados disponibles.
                            </p>
                            <?php
                        endif;
                    }
                    ?>
                </div>
            </section>
            
            <!-- Sección de Comentarios (Opcional) -->
            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
            
        </article>
        
    <?php endwhile; ?>
    
</div>

<?php get_footer(); ?>

