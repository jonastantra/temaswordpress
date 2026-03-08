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
                                <?php the_post_thumbnail('episode-thumb'); ?>
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

<!-- Navegación por Sagas -->
<section class="container" style="margin-bottom: 4rem;">
    <h2 class="section-title">Explorar por Sagas</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
        <?php
        $sagas = get_categories(array(
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => true
        ));
        
        foreach ($sagas as $saga) :
            ?>
            <a href="<?php echo get_category_link($saga->term_id); ?>" class="episode-card" style="text-align: center; padding: 2rem 1rem;">
                <div style="font-size: 3rem; color: var(--color-primary); margin-bottom: 1rem;">
                    <i class="fas fa-dragon"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--color-text);">
                    <?php echo esc_html($saga->name); ?>
                </h3>
                <p style="color: var(--color-text-muted); font-size: 0.9rem;">
                    <?php echo $saga->count; ?> episodios disponibles
                </p>
            </a>
            <?php
        endforeach;
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
            'order' => 'DESC'
        ));
        
        if ($all_episodes->have_posts()) :
            while ($all_episodes->have_posts()) : $all_episodes->the_post();
                ?>
                <article class="episode-card">
                    <a href="<?php the_permalink(); ?>">
                        <div class="episode-thumbnail">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('episode-thumb'); ?>
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

