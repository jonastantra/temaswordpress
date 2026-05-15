/**
 * Los Simpsons Online - Main JavaScript
 * Text Domain: simpsons-online
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

        const mobileLinks = mobileNavigation.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const parentLi = this.closest('li');
                if (parentLi.classList.contains('menu-item-has-children')) {
                    e.preventDefault();
                    parentLi.classList.toggle('submenu-open');
                } else {
                    mobileMenuToggle.classList.remove('active');
                    mobileNavigation.classList.remove('active');
                    document.body.classList.remove('menu-open');
                }
            });
        });
        
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
    // 1B. MENÚ DROPDOWN MEJORADO (CON DELAY - NO SE CIERRA TAN RÁPIDO)
    // ===========================
    const menuItems = document.querySelectorAll('.nav-menu > li.menu-item-has-children');
    
    menuItems.forEach(item => {
        let timeoutId;
        
        item.addEventListener('mouseenter', function() {
            clearTimeout(timeoutId);
            const submenu = this.querySelector('ul.sub-menu');
            if (submenu) {
                submenu.style.display = 'block';
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
                // DELAY DE 300MS - Evita que se cierre tan rápido
                timeoutId = setTimeout(() => {
                    submenu.style.opacity = '0';
                    submenu.style.pointerEvents = 'none';
                    submenu.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        submenu.style.display = 'none';
                    }, 300);
                }, 300);
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
                    const offsetTop = target.offsetTop - 80;
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
            
            if (currentScroll > lastScroll && currentScroll > 300) {
                siteHeader.classList.add('header-hidden');
            } else {
                siteHeader.classList.remove('header-hidden');
            }
            
            lastScroll = currentScroll;
        });
    }

    // ===========================
    // 4. LAZY LOADING DE IMÁGENES
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
        lazyImages.forEach(img => {
            img.src = img.dataset.src;
        });
    }

    // ===========================
    // 5. LOADING INICIAL
    // ===========================
    window.addEventListener('load', function() {
        document.body.classList.add('loaded');
    });

    // ===========================
    // 6. ANIMACIONES AL SCROLL
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
// FUNCIÓN GLOBAL: openTab (Reproductor de video)
// ===========================
function openTab(event, tabId) {
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.classList.remove('active');
    });
    
    const tabs = document.querySelectorAll('.player-tabs .tab');
    tabs.forEach(tab => {
        tab.classList.remove('active');
    });
    
    const selectedContent = document.getElementById(tabId);
    if (selectedContent) {
        selectedContent.classList.add('active');
    }
    
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    }
    
    const playerContainer = document.querySelector('.video-player-container');
    if (playerContainer && window.innerWidth < 768) {
        playerContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// Estilos de animaciones
if (!document.querySelector('#custom-animations-style')) {
    const style = document.createElement('style');
    style.id = 'custom-animations-style';
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(400px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(400px); opacity: 0; }
        }
        .processing {
            opacity: 0.6;
            pointer-events: none;
        }
    `;
    document.head.appendChild(style);
}

