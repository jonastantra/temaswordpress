<?php
/**
 * Page Template - Páginas Estáticas
 */

get_header(); ?>

<div class="container" style="padding: 2rem;">
    
    <?php while (have_posts()) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <!-- Breadcrumbs -->
            <?php dbonline_breadcrumbs(); ?>
            
            <header style="margin-bottom: 2rem;">
                <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; color: var(--color-text);">
                    <?php the_title(); ?>
                </h1>
            </header>
            
            <div style="background: var(--color-dark-light); padding: 2rem; border-radius: 12px; line-height: 1.8;">
                <?php
                if (has_post_thumbnail()) :
                    ?>
                    <div style="margin-bottom: 2rem; border-radius: 12px; overflow: hidden;">
                        <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: auto;')); ?>
                    </div>
                    <?php
                endif;
                ?>
                
                <div class="page-content" style="color: var(--color-text-muted);">
                    <?php the_content(); ?>
                </div>
                
                <?php
                wp_link_pages(array(
                    'before' => '<div class="page-links" style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--color-dark);">',
                    'after'  => '</div>',
                ));
                ?>
            </div>
            
            <?php
            // Si los comentarios están abiertos o hay al menos un comentario
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
            
        </article>
        
    <?php endwhile; ?>
    
</div>

<?php get_footer(); ?>

