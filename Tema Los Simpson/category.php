<?php
/**
 * Category Template - Listado por categoría/temporada
 */

get_header(); ?>

<div class="container" style="padding: 2rem;">
    
    <?php if (have_posts()) : ?>
        
        <header class="archive-header">
            <?php if (function_exists('simpsons_add_breadcrumb_schema')) : ?>
                <div class="category-breadcrumbs">
                    <a href="<?php echo home_url(); ?>">Inicio</a> <i class="fas fa-chevron-right"></i> <span><?php single_cat_title(); ?></span>
                </div>
            <?php endif; ?>
            <h1>Ver <?php single_cat_title(); ?> Online Gratis</h1>
            <?php
            $category_description = category_description();
            if ($category_description) :
                ?>
                <div class="category-description"><?php echo $category_description; ?></div>
            <?php else : ?>
                <div class="category-description">
                    Disfruta de todos los capítulos de <?php single_cat_title(); ?> en español latino. 
                    Tenemos <?php echo $wp_query->found_posts; ?> episodios disponibles para ver online en alta calidad.
                </div>
            <?php endif; ?>
        </header>

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
        
        <div class="archive-header">
            <h1><?php single_cat_title(); ?></h1>
        </div>
        
        <p class="no-episodes">No hay capítulos disponibles en esta categoría.</p>
        
    <?php endif; ?>
    
</div>

<?php get_footer(); ?>

