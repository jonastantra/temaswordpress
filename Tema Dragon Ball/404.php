<?php
/**
 * 404 Template - Página de error
 */

get_header(); ?>

<div class="container" style="padding: 2rem;">
    
    <div class="error-404">
        <h1>404</h1>
        <h2>¡Oops! Página no encontrada</h2>
        <p>La página que buscas no existe o ha sido movida. Vuelve al inicio o busca el episodio que deseas ver.</p>
        
        <div style="margin: 2rem 0;">
            <a href="<?php echo home_url(); ?>" class="btn-primary">
                <i class="fas fa-home"></i> Volver al Inicio
            </a>
        </div>
        
        <!-- Buscador -->
        <div style="max-width: 600px; margin: 3rem auto;">
            <h3 style="margin-bottom: 1rem; color: var(--color-text);">Buscar Episodios</h3>
            <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>" style="background: var(--color-dark-light); border-radius: 50px; padding: 0.5rem; display: flex; box-shadow: var(--shadow-md);">
                <input type="search" class="search-input" placeholder="Buscar episodios de Dragon Ball..." name="s" style="flex: 1; font-size: 1rem;">
                <button type="submit" class="search-submit" style="border-radius: 50px; padding: 0.75rem 2rem; font-weight: 600;">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>
        </div>
    </div>
    
    <!-- Categorías Populares -->
    <section style="margin-top: 4rem;">
        <h2 class="section-title">Explorar Sagas Populares</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
            <?php
            $popular_cats = get_categories(array(
                'orderby' => 'count',
                'order' => 'DESC',
                'hide_empty' => true,
                'number' => 6
            ));
            
            foreach ($popular_cats as $category) :
                ?>
                <a href="<?php echo get_category_link($category->term_id); ?>" class="episode-card" style="text-align: center; padding: 2rem 1rem;">
                    <div style="font-size: 2.5rem; color: var(--color-primary); margin-bottom: 1rem;">
                        <i class="fas fa-dragon"></i>
                    </div>
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--color-text);">
                        <?php echo esc_html($category->name); ?>
                    </h3>
                    <p style="color: var(--color-text-muted); font-size: 0.85rem;">
                        <?php echo $category->count; ?> episodios
                    </p>
                </a>
                <?php
            endforeach;
            ?>
        </div>
    </section>
    
    <!-- Episodios Recientes -->
    <section style="margin-top: 4rem;">
        <h2 class="section-title">Episodios Recientes</h2>
        
        <div class="episodes-grid">
            <?php
            $recent = new WP_Query(array(
                'posts_per_page' => 8,
                'orderby' => 'date',
                'order' => 'DESC',
                'ignore_sticky_posts' => true
            ));
            
            if ($recent->have_posts()) :
                while ($recent->have_posts()) : $recent->the_post();
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
    
</div>

<?php get_footer(); ?>

