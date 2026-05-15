/**
 * Dragon Ball Online - Main JavaScript
 * Text Domain: db-online
 */

(function() {
    'use strict';

    // ===========================
    // 1. MENÚ MÓVIL
    // ===========================
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileNavigation = document.querySelector('.mobile-navigation');
    
    if (mobileMenuToggle && mobileNavigation) {
        mobileMenuToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            mobileNavigation.classList.toggle('active');
            document.body.classList.toggle('menu-open');
        });

        // Cerrar menú al hacer click en un enlace (solo links sin submenú)
        const mobileLinks = mobileNavigation.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Si el enlace tiene submenú, no cerrar el menú
                const parentLi = this.closest('li');
                if (parentLi.classList.contains('menu-item-has-children')) {
                    e.preventDefault();
                    parentLi.classList.toggle('submenu-open');
                } else {
                    // Si no tiene submenú, cerrar todo
                    mobileMenuToggle.classList.remove('active');
                    mobileNavigation.classList.remove('active');
                    document.body.classList.remove('menu-open');
                }
            });
        });
        
        // Cerrar menú al hacer click fuera de él
        document.addEventListener('click', function(event) {
            const isClickInsideMenu = mobileNavigation.contains(event.target);
            const isClickOnToggle = mobileMenuToggle.contains(event.target);
            
            if (!isClickInsideMenu && !isClickOnToggle && mobileNavigation.classList.contains('active')) {
                mobileMenuToggle.classList.remove('active');
                mobileNavigation.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
        });
    }

    // ===========================
    // 1B. MEJORAR MENÚ DROPDOWN (evitar cierre rápido)
    // ===========================
    const menuItems = document.querySelectorAll('.nav-menu > li.menu-item-has-children');
    
    menuItems.forEach(item => {
        let timeoutId;
        
        item.addEventListener('mouseenter', function() {
            clearTimeout(timeoutId);
            const submenu = this.querySelector('ul.sub-menu');
            if (submenu) {
                submenu.style.display = 'block';
                // Pequeño delay para la animación
                setTimeout(() => {
                    submenu.style.opacity = '1';
                    submenu.style.pointerEvents = 'auto';
                    submenu.style.transform = 'translateY(0)';
                }, 10);
            }
        });
        
        item.addEventListener('mouseleave', function() {
            const submenu = this.querySelector('ul.sub-menu');
            if (submenu) {
                // Delay de 300ms antes de cerrar (evita cierre accidental)
                timeoutId = setTimeout(() => {
                    submenu.style.opacity = '0';
                    submenu.style.pointerEvents = 'none';
                    submenu.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        submenu.style.display = 'none';
                    }, 300);
                }, 300); // Ajusta este valor si quieres más/menos delay
            }
        });
    });

    // ===========================
    // 2. SMOOTH SCROLL
    // ===========================
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    
    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href !== '#' && href !== '#0') {
                const target = document.querySelector(href);
                
                if (target) {
                    e.preventDefault();
                    
                    const offsetTop = target.offsetTop - 80; // 80px para el header fijo
                    
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // ===========================
    // 3. HEADER STICKY (scroll)
    // ===========================
    const siteHeader = document.getElementById('site-header');
    
    if (siteHeader) {
        let lastScroll = 0;
        
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 100) {
                siteHeader.classList.add('scrolled');
            } else {
                siteHeader.classList.remove('scrolled');
            }
            
            // Ocultar/mostrar header al hacer scroll
            if (currentScroll > lastScroll && currentScroll > 300) {
                siteHeader.classList.add('header-hidden');
            } else {
                siteHeader.classList.remove('header-hidden');
            }
            
            lastScroll = currentScroll;
        });
    }

    // ===========================
    // 4. BUSCADOR - MOSTRAR/OCULTAR
    // ===========================
    const searchToggle = document.querySelector('.search-toggle');
    const searchForm = document.querySelector('.header-search');
    
    if (searchToggle && searchForm) {
        searchToggle.addEventListener('click', function() {
            searchForm.classList.toggle('active');
            const searchInput = searchForm.querySelector('.search-input');
            if (searchInput) {
                searchInput.focus();
            }
        });
    }

    // ===========================
    // 5. LAZY LOADING DE IMÁGENES
    // ===========================
    const lazyImages = document.querySelectorAll('img[data-src]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        lazyImages.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback para navegadores sin soporte
        lazyImages.forEach(img => {
            img.src = img.dataset.src;
        });
    }

    // ===========================
    // 6. LOADING INICIAL
    // ===========================
    window.addEventListener('load', function() {
        document.body.classList.add('loaded');
    });

    // ===========================
    // 7. PREVENIR CLICKS MÚLTIPLES EN BOTONES
    // ===========================
    const buttons = document.querySelectorAll('button[type="submit"], .btn');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.classList.contains('processing')) {
                return false;
            }
            this.classList.add('processing');
            
            setTimeout(() => {
                this.classList.remove('processing');
            }, 2000);
        });
    });

    // ===========================
    // 8. ANIMACIONES AL SCROLL (Reveal)
    // ===========================
    const revealElements = document.querySelectorAll('.episode-card, .section-title');
    
    if ('IntersectionObserver' in window && revealElements.length > 0) {
        const revealObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1
        });
        
        revealElements.forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            revealObserver.observe(element);
        });
    }

})();

// ===========================
// FUNCIÓN GLOBAL: openTab (Para el reproductor de video)
// CRÍTICO: Esta función debe estar en el scope global
// ===========================
function openTab(event, tabId) {
    // Ocultar todos los contenidos de pestañas
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.classList.remove('active');
    });
    
    // Remover clase active de todas las pestañas
    const tabs = document.querySelectorAll('.player-tabs .tab');
    tabs.forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Mostrar el contenido de la pestaña seleccionada
    const selectedContent = document.getElementById(tabId);
    if (selectedContent) {
        selectedContent.classList.add('active');
    }
    
    // Activar la pestaña clickeada
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    }
    
    // Scroll suave hacia el reproductor (útil en móvil)
    const playerContainer = document.querySelector('.video-player-container');
    if (playerContainer && window.innerWidth < 768) {
        playerContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// ===========================
// FUNCIÓN: Copiar enlace de episodio
// ===========================
function copyEpisodeLink() {
    const url = window.location.href;
    
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(function() {
            showNotification('¡Enlace copiado al portapapeles!');
        }).catch(function(err) {
            console.error('Error al copiar:', err);
        });
    } else {
        // Fallback para navegadores sin soporte
        const textArea = document.createElement('textarea');
        textArea.value = url;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        document.body.appendChild(textArea);
        textArea.select();
        
        try {
            document.execCommand('copy');
            showNotification('¡Enlace copiado al portapapeles!');
        } catch (err) {
            console.error('Error al copiar:', err);
        }
        
        document.body.removeChild(textArea);
    }
}

// ===========================
// FUNCIÓN: Mostrar notificaciones
// ===========================
function showNotification(message) {
    // Verificar si ya existe una notificación
    let notification = document.querySelector('.custom-notification');
    
    if (!notification) {
        notification = document.createElement('div');
        notification.className = 'custom-notification';
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: var(--color-primary);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            font-weight: 600;
            animation: slideIn 0.3s ease;
        `;
        document.body.appendChild(notification);
    }
    
    notification.textContent = message;
    notification.style.display = 'block';
    
    setTimeout(function() {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(function() {
            notification.style.display = 'none';
        }, 300);
    }, 3000);
}

// ===========================
// CSS ANIMATIONS (agregadas dinámicamente)
// ===========================
if (!document.querySelector('#custom-animations-style')) {
    const style = document.createElement('style');
    style.id = 'custom-animations-style';
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
        
        .processing {
            opacity: 0.6;
            pointer-events: none;
        }
    `;
    document.head.appendChild(style);
}

