<?php
/**
 * 404 Template - Página de error
 */

get_header(); ?>

<div class="container" style="padding: 2rem;">
    
    <div class="error-404">
        <h1>404</h1>
        <h2>¡D'oh! Página no encontrada</h2>
        <p>La página que buscas no existe o ha sido movida. Vuelve al inicio o busca el capítulo que deseas ver.</p>
        
        <div style="margin: 2rem 0;">
            <a href="<?php echo home_url(); ?>" class="btn-primary">
                <i class="fas fa-home"></i> Volver al Inicio
            </a>
        </div>
        
        <div style="max-width: 600px; margin: 3rem auto;">
            <h3 style="margin-bottom: 1rem; color: var(--color-text);">Buscar Capítulos</h3>
            <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>" style="background: var(--color-dark-light); border-radius: 50px; padding: 0.5rem; display: flex; box-shadow: var(--shadow-md);">
                <input type="search" class="search-input" placeholder="Buscar capítulos de Los Simpsons..." name="s" style="flex: 1; font-size: 1rem;">
                <button type="submit" class="search-submit" style="border-radius: 50px; padding: 0.75rem 2rem; font-weight: 600;">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>
        </div>
    </div>
    
    <section style="margin-top: 4rem;">
        <h2 class="section-title">Explorar Temporadas Populares</h2>
        
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
                        <i class="fas fa-tv"></i>
                    </div>
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--color-text);">
                        <?php echo esc_html($category->name); ?>
                    </h3>
                    <p style="color: var(--color-text-muted); font-size: 0.85rem;">
                        <?php echo $category->count; ?> capítulos
                    </p>
                </a>
                <?php
            endforeach;
            ?>
        </div>
    </section>
    
</div>

<?php get_footer(); ?>

