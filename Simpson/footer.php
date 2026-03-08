</main><!-- #main-content -->

<footer id="site-footer" class="site-footer">
    <div class="footer-container">
        
        <!-- Footer Widgets -->
        <div class="footer-widgets">
            <div class="footer-widget">
                <h3>Sobre <?php bloginfo('name'); ?></h3>
                <p>Tu sitio favorito para ver todos los capítulos de Los Simpsons online. Todas las temporadas completas en español latino. ¡Disfruta de Homer, Bart, Lisa, Marge y toda la familia Simpson!</p>
            </div>

            <div class="footer-widget">
                <h3>Enlaces Rápidos</h3>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_class' => 'footer-menu',
                    'container' => false,
                    'fallback_cb' => function() {
                        echo '<ul class="footer-menu">';
                        echo '<li><a href="' . home_url() . '">Inicio</a></li>';
                        
                        $categories = get_categories(array(
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'hide_empty' => true,
                            'number' => 5
                        ));
                        
                        foreach ($categories as $category) {
                            echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
                        }
                        
                        echo '</ul>';
                    }
                ));
                ?>
            </div>

            <div class="footer-widget">
                <h3>Temporadas</h3>
                <ul class="footer-menu">
                    <?php
                    $categories = get_categories(array(
                        'orderby' => 'name',
                        'order' => 'ASC',
                        'hide_empty' => true,
                        'number' => 7
                    ));
                    
                    foreach ($categories as $category) {
                        echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Todos los derechos reservados.</p>
            <p class="disclaimer">Los Simpsons es propiedad de Fox Broadcasting Company y Matt Groening. Este sitio es solo para fines de entretenimiento.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

