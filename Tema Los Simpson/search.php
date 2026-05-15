<?php
/**
 * Search Template - Resultados de búsqueda
 */

get_header(); ?>

<div class="container" style="padding: 2rem;">
    
    <header class="archive-header">
        <h1>
            <?php
            printf(
                __('Resultados de búsqueda: %s', 'simpsons-online'),
                '<span style="color: var(--color-primary);">' . get_search_query() . '</span>'
            );
            ?>
        </h1>
        <?php if (have_posts()) : ?>
            <p class="category-description">
                Se encontraron <?php echo $wp_query->found_posts; ?> capítulos que coinciden con tu búsqueda.
            </p>
        <?php endif; ?>
    </header>
    
    <?php if (have_posts()) : ?>

        <div class="episodes-archive-grid">
            <?php while (have_posts()) : the_post(); ?>
                
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

            <?php endwhile; ?>
        </div>
        
        <div class="pagination">
            <?php
            echo paginate_links(array(
                'prev_text' => '<i class="fas fa-chevron-left"></i> Anterior',
                'next_text' => 'Siguiente <i class="fas fa-chevron-right"></i>',
            ));
            ?>
        </div>
        
    <?php else : ?>
        
        <div style="text-align: center; padding: 4rem 2rem; background: var(--color-dark-light); border-radius: 12px; margin-top: 2rem;">
            <div style="font-size: 4rem; color: var(--color-text-muted); margin-bottom: 1.5rem;">
                <i class="fas fa-search"></i>
            </div>
            <h2 style="font-size: 1.75rem; margin-bottom: 1rem; color: var(--color-text);">
                No se encontraron resultados
            </h2>
            <p style="color: var(--color-text-muted); font-size: 1.1rem; margin-bottom: 2rem;">
                No pudimos encontrar capítulos que coincidan con "<strong><?php echo get_search_query(); ?></strong>". 
                Intenta con otros términos de búsqueda.
            </p>
            
            <div style="max-width: 500px; margin: 0 auto;">
                <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>" style="background: var(--color-dark); border-radius: 50px; padding: 0.5rem; display: flex; box-shadow: var(--shadow-md);">
                    <input type="search" class="search-input" placeholder="Buscar otro capítulo..." name="s" style="flex: 1; font-size: 1rem;">
                    <button type="submit" class="search-submit" style="border-radius: 50px; padding: 0.75rem 2rem; font-weight: 600;">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </form>
            </div>
        </div>
        
    <?php endif; ?>
    
</div>

<?php get_footer(); ?>

