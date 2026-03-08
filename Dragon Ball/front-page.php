<?php
/**
 * Front Page Template - Página de Inicio
 */

get_header(); ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">Ver Dragon Ball Online - Todos los Episodios</h1>
        <p class="hero-subtitle">Disfruta de todas las sagas: DB, DBZ, GT, Super, Kai y más</p>
        
        <!-- Buscador Destacado -->
        <div style="max-width: 600px; margin: 0 auto;">
            <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>" style="background: white; border-radius: 50px; padding: 0.5rem; display: flex; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);">
                <input type="search" class="search-input" placeholder="Buscar episodios de Dragon Ball..." name="s" value="<?php echo get_search_query(); ?>" style="flex: 1; color: #0f0f0f; font-size: 1rem;">
                <button type="submit" class="search-submit" style="border-radius: 50px; padding: 0.75rem 2rem; font-weight: 600;">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Episodios Destacados/Recientes -->
<section class="container" style="margin-bottom: 4rem;">
    <h2 class="section-title">Episodios Recientes</h2>
    
    <div class="episodes-grid">
        <?php
        $recent_episodes = new WP_Query(array(
            'posts_per_page' => 8,
            'orderby' => 'date',
            'order' => 'DESC'
        ));
        
        if ($recent_episodes->have_posts()) :
            while ($recent_episodes->have_posts()) : $recent_episodes->the_post();
                ?>
                <article class="episode-card">
                    <a href="<?php the_permalink(); ?>">
                        <div class="episode-thumbnail">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('episode-thumb', array('alt' => 'Episodio ' . get_the_title())); ?>
                            <?php else : ?>
                                <div class="placeholder-thumb">
                                    <i class="fas fa-video"></i>
                                </div>
                            <?php endif; ?>
                            
                            <?php 
                            $categories = get_the_category();
                            if (!empty($categories)) :
                            ?>
                                <span class="saga-badge">
                                    <?php echo esc_html($categories[0]->name); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="episode-info">
                            <h3 class="episode-title"><?php the_title(); ?></h3>
                            <div class="episode-meta">
                                <span class="episode-date">
                                    <i class="far fa-calendar"></i>
                                    <?php echo get_the_date(); ?>
                                </span>
                            </div>
                        </div>
                    </a>
                </article>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</section>



<!-- Listado Completo de Episodios -->
<section class="container" style="margin-bottom: 4rem;">
    <h2 class="section-title">Todos los Episodios</h2>
    
    <div class="episodes-grid">
        <?php
        $all_episodes = new WP_Query(array(
            'posts_per_page' => 24,
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
            'orderby' => 'date',
            'order' => 'DESC',
            'no_found_rows' => true, // Optimización crítica: Evita el conteo total en SQL reduciendo la RAM
            'update_post_meta_cache' => false, // Evita cargar meta-data innecesaria al index principal
            'update_post_term_cache' => false // Evita cacheado de terminos en cada card
        ));
        
        if ($all_episodes->have_posts()) :
            while ($all_episodes->have_posts()) : $all_episodes->the_post();
                ?>
                <article class="episode-card">
                    <a href="<?php the_permalink(); ?>">
                        <div class="episode-thumbnail">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('episode-thumb', array('alt' => 'Ver episodio ' . get_the_title())); ?>
                            <?php else : ?>
                                <div class="placeholder-thumb">
                                    <i class="fas fa-video"></i>
                                </div>
                            <?php endif; ?>
                            
                            <?php 
                            $categories = get_the_category();
                            if (!empty($categories)) :
                            ?>
                                <span class="saga-badge">
                                    <?php echo esc_html($categories[0]->name); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="episode-info">
                            <h3 class="episode-title"><?php the_title(); ?></h3>
                            <div class="episode-meta">
                                <span class="episode-date">
                                    <i class="far fa-calendar"></i>
                                    <?php echo get_the_date(); ?>
                                </span>
                            </div>
                        </div>
                    </a>
                </article>
                <?php
            endwhile;
            ?>
            
            <!-- Paginación -->
            <div class="pagination" style="grid-column: 1 / -1;">
                <?php
                echo paginate_links(array(
                    'total' => $all_episodes->max_num_pages,
                    'current' => max(1, get_query_var('paged')),
                    'prev_text' => '<i class="fas fa-chevron-left"></i> Anterior',
                    'next_text' => 'Siguiente <i class="fas fa-chevron-right"></i>',
                ));
                ?>
            </div>
            
            <?php
            wp_reset_postdata();
        endif;
        ?>
    </div>
</section>

<?php get_footer(); ?>

