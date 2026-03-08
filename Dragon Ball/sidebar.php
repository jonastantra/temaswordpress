<?php
/**
 * Sidebar Template
 */

if (!is_active_sidebar('sidebar-episodes')) {
    return;
}
?>

<aside id="sidebar" class="sidebar" style="background: var(--color-dark-light); padding: 2rem; border-radius: 12px; margin-top: 2rem;">
    <?php dynamic_sidebar('sidebar-episodes'); ?>
    
    <!-- Categorías Populares -->
    <div class="widget">
        <h3 class="widget-title" style="color: var(--color-primary); font-size: 1.2rem; margin-bottom: 1rem; font-weight: 700;">Sagas Populares</h3>
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem;">
            <?php
            $categories = get_categories(array(
                'orderby' => 'count',
                'order' => 'DESC',
                'hide_empty' => true,
                'number' => 5
            ));
            
            foreach ($categories as $category) {
                echo '<li>';
                echo '<a href="' . get_category_link($category->term_id) . '" style="display: flex; justify-content: space-between; padding: 0.75rem; background: var(--color-dark); border-radius: 8px; color: var(--color-text); transition: var(--transition);">';
                echo '<span>' . $category->name . '</span>';
                echo '<span style="color: var(--color-primary);">' . $category->count . ' episodios</span>';
                echo '</a>';
                echo '</li>';
            }
            ?>
        </ul>
    </div>
    
    <!-- Episodios Recientes -->
    <div class="widget" style="margin-top: 2rem;">
        <h3 class="widget-title" style="color: var(--color-primary); font-size: 1.2rem; margin-bottom: 1rem; font-weight: 700;">Episodios Recientes</h3>
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.75rem;">
            <?php
            $recent_posts = new WP_Query(array(
                'posts_per_page' => 5,
                'orderby' => 'date',
                'order' => 'DESC'
            ));
            
            if ($recent_posts->have_posts()) :
                while ($recent_posts->have_posts()) : $recent_posts->the_post();
                    ?>
                    <li>
                        <a href="<?php the_permalink(); ?>" style="display: flex; gap: 1rem; background: var(--color-dark); padding: 0.75rem; border-radius: 8px; transition: var(--transition);">
                            <?php if (has_post_thumbnail()) : ?>
                                <div style="flex-shrink: 0; width: 80px; height: 45px; overflow: hidden; border-radius: 6px;">
                                    <?php the_post_thumbnail('thumbnail', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                                </div>
                            <?php endif; ?>
                            <div style="flex: 1; min-width: 0;">
                                <h4 style="font-size: 0.9rem; font-weight: 600; color: var(--color-text); margin-bottom: 0.25rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php the_title(); ?></h4>
                                <span style="font-size: 0.75rem; color: var(--color-text-muted);">
                                    <i class="far fa-calendar"></i> <?php echo get_the_date(); ?>
                                </span>
                            </div>
                        </a>
                    </li>
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </ul>
    </div>
</aside>

