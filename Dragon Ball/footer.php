</main><!-- #main-content -->

<footer id="site-footer" class="site-footer">
    <div class="footer-container">
        
        <!-- Footer Widgets -->
        <div class="footer-widgets">
            <div class="footer-widget">
                <h3>Sobre <?php bloginfo('name'); ?></h3>
                <p>Tu sitio favorito para ver todos los episodios de Dragon Ball, Dragon Ball Z, GT, Super y más. Actualizamos constantemente con nuevos capítulos de todas las sagas.</p>
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
                        
                        // Obtener categorías principales
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
                <h3>Categorías</h3>
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
            <div class="footer-legal-links">
                <a href="<?php echo home_url('/politica-de-privacidad/'); ?>">Política de Privacidad</a> | 
                <a href="<?php echo home_url('/aviso-legal/'); ?>">Aviso Legal</a>
            </div>
            <p class="disclaimer">Dragon Ball es propiedad de Toei Animation, Fuji TV y Akira Toriyama. Este sitio es solo para fines de entertainment.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

