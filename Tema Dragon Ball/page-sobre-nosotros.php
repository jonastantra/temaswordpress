<?php
/**
 * Template Name: Sobre Nosotros
 * Página de autor/editorial para E-E-A-T
 */

get_header(); ?>

<div class="container" style="padding: 2rem;">
    
    <article class="about-page" style="max-width: 800px; margin: 0 auto;">
        
        <!-- Breadcrumbs -->
        <nav class="breadcrumbs" style="margin-bottom: 2rem;">
            <a href="<?php echo home_url(); ?>">Inicio</a>
            <i class="fas fa-chevron-right" style="margin: 0 0.5rem;"></i>
            <span>Sobre Nosotros</span>
        </nav>
        
        <header class="about-header" style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Sobre Nosotros</h1>
            <p style="font-size: 1.2rem; color: #a0a0a0;">Dragon Ball HD Sin Límites</p>
        </header>
        
        <div class="about-content" style="line-height: 1.8; font-size: 1.1rem;">
            
            <section style="margin-bottom: 2rem;">
                <h2 style="color: #ff6b1a; margin-bottom: 1rem;">Nuestra Historia</h2>
                <p>
                    Soy <strong>jonastantra</strong>, fan de Dragon Ball desde hace más de 20 años. 
                    Dragon Ball HD Sin Límites nació con el objetivo de ofrecer a la comunidad 
                    hispanohablante acceso a los episodios de Dragon Ball, Dragon Ball Z, 
                    Dragon Ball GT, Dragon Ball Super, Dragon Ball Kai y películas en 
                    español latino con la mejor calidad posible.
                </p>
            </section>
            
            <section style="margin-bottom: 2rem;">
                <h2 style="color: #ff6b1a; margin-bottom: 1rem;">Nuestra Misión</h2>
                <p>
                    Proporcionar una experiencia de visualización de anime fluida y accesible, 
                    con reproductores optimizados para diferentes dispositivos y conexiones. 
                    Actualizamos constantemente nuestro catálogo para incluir los episodios más 
                    recientes de las series en emisión.
                </p>
            </section>
            
            <section style="margin-bottom: 2rem;">
                <h2 style="color: #ff6b1a; margin-bottom: 1rem;">Contenido</h2>
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 0.5rem 0; border-bottom: 1px solid #333;">
                        <strong>Dragon Ball</strong> — La saga original de Akira Toriyama
                    </li>
                    <li style="padding: 0.5rem 0; border-bottom: 1px solid #333;">
                        <strong>Dragon Ball Z</strong> — La continuación más épica
                    </li>
                    <li style="padding: 0.5rem 0; border-bottom: 1px solid #333;">
                        <strong>Dragon Ball GT</strong> — Una aventura alternativa
                    </li>
                    <li style="padding: 0.5rem 0; border-bottom: 1px solid #333;">
                        <strong>Dragon Ball Super</strong> — Nuevas sagas, nuevos torneos
                    </li>
                    <li style="padding: 0.5rem 0; border-bottom: 1px solid #333;">
                        <strong>Dragon Ball Kai</strong> — Versión remasterizada
                    </li>
                </ul>
            </section>
            
            <section style="margin-bottom: 2rem;">
                <h2 style="color: #ff6b1a; margin-bottom: 1rem;">Aviso Legal</h2>
                <p style="font-size: 0.95rem; color: #888;">
                    Dragon Ball HD Sin Límites es un sitio fan-made. No almacenamos ningún 
                    archivo de video en nuestros servidores. Todo el contenido es proporcionado 
                    a través de iframes de reproductores de terceros. Este sitio es creado por 
                    fans para fans y no tiene relación oficial con Toei Animation o Shueisha.
                </p>
            </section>
            
            <section style="text-align: center; padding: 2rem; background: #1a1a1a; border-radius: 12px;">
                <h2 style="color: #ff6b1a; margin-bottom: 1rem;">Síguenos</h2>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <a href="https://www.facebook.com/dragonballhdsinlimites" target="_blank" rel="noopener" 
                       style="background: #3b5998; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none;">
                        <i class="fab fa-facebook"></i> Facebook
                    </a>
                    <a href="https://twitter.com/dragonballhdsinlimites" target="_blank" rel="noopener" 
                       style="background: #1da1f2; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none;">
                        <i class="fab fa-twitter"></i> Twitter
                    </a>
                </div>
            </section>
            
        </div>
        
    </article>
    
</div>

<?php get_footer(); ?>
