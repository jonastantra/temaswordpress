# 📺 Simpsons Online Pro - Tema WordPress para Los Simpsons

Tema personalizado optimizado para sitios web de capítulos de Los Simpsons. Diseño moderno con colores amarillo Simpson y excelente SEO.

## 📋 Características Principales

### ✨ Diseño y Funcionalidad
- **Diseño Oscuro Moderno**: Con colores amarillo y azul de Los Simpsons
- **Sistema de Reproductores**: 3 opciones de reproductor por capítulo con pestañas
- **Responsive**: Perfectamente adaptado a móviles, tablets y escritorio
- **SEO Optimizado**: Keywords de Los Simpsons, Schema markup completo
- **Navegación Intuitiva**: Sistema de navegación entre capítulos (anterior/siguiente)
- **Búsqueda Avanzada**: Buscador optimizado de capítulos
- **Categorías por Temporadas**: Organiza tus capítulos por temporadas

### 🎨 Colores Los Simpsons
- **Amarillo Principal**: #FFD90F (amarillo icónico de Los Simpsons)
- **Azul Secundario**: #0088CC (azul brillante)
- **Naranja Acento**: #FF6B35 (naranja suave)
- **Fondo Oscuro**: #1a1a1a (optimizado para videos)

### 🎯 Características SEO - Los Simpsons
- Schema.org con keywords de Los Simpsons
- Meta tags: "Los Simpsons online", "ver Simpsons", "Springfield"
- Rich snippets con personajes: Homer, Bart, Lisa, Marge
- Creador: Matt Groening
- Productora: Fox Broadcasting Company
- Open Graph optimizado para redes sociales

### 📱 Tecnologías
- **CSS Optimizado**: Sin frameworks pesados (sin Tailwind)
- **Font Awesome 6**: Solo subset necesario
- **Google Fonts**: Poppins y Bangers con font-display: swap
- **JavaScript Vanilla**: Sin dependencias jQuery
- **ACF**: Para campos personalizados del reproductor

## 📦 Requisitos

- **WordPress**: 5.0 o superior
- **PHP**: 7.4 o superior
- **Plugin requerido**: Advanced Custom Fields (ACF) - Versión gratuita

## 🚀 Instalación Rápida

### Paso 1: Instalar el Tema

1. Comprime la carpeta `simpsons-online-theme` en ZIP
2. WordPress → **Apariencia** → **Temas** → **Añadir nuevo**
3. **Subir tema** → Selecciona el ZIP
4. **Instalar ahora** → **Activar**

### Paso 2: Instalar ACF

1. **Plugins** → **Añadir nuevo**
2. Buscar: "Advanced Custom Fields"
3. Instalar y activar

### Paso 3: Configurar Campos ACF

Crea 3 campos tipo "Área de texto":
- `player1` (obligatorio)
- `player2` (opcional)
- `player3` (opcional)

Ubicación: Tipo de entrada = Entrada

### Paso 4: Crear Categorías (Temporadas)

Ejemplo de categorías:
- Temporada 1
- Temporada 2
- Temporada 3
- ... (hasta la temporada actual)
- Especiales
- La Película

### Paso 5: Configurar Menú

1. **Apariencia** → **Menús**
2. Crear menú con tus temporadas favoritas
3. Asignar a "Menú Principal"

## 📝 Crear un Capítulo

1. **Entradas** → **Añadir nueva**
2. **Título**: "Los Simpsons Temporada 1 Capítulo 1 - Especial de Navidad"
3. **Contenido**: Escribe la sinopsis del capítulo
4. **Imagen destacada**: Thumbnail del capítulo
5. **Categoría**: Selecciona la temporada
6. **Campos ACF**:
   - Player 1: Código iframe del reproductor
   - Player 2: Reproductor alternativo (opcional)
   - Player 3: Tercer reproductor (opcional)
7. **Publicar**

## 🎨 Colores Personalizados

Variables en `style.css`:

```css
:root {
    --color-primary: #FFD90F;      /* Amarillo Simpson */
    --color-secondary: #0088CC;     /* Azul brillante */
    --color-dark: #1a1a1a;         /* Fondo oscuro */
    --color-accent: #FF6B35;        /* Naranja acento */
}
```

## 🔍 Keywords SEO Implementadas

### Keywords Principales:
- Los Simpsons online
- ver Los Simpsons
- Simpsons capítulos
- Los Simpsons temporadas
- Simpsons español latino
- Homer Simpson
- Bart Simpson
- Springfield

### Long-tail Keywords:
- "Los Simpsons temporada X online"
- "ver Simpsons español latino gratis"
- "capítulos completos Simpsons"
- "Los Simpsons HD"

## 📊 Optimizaciones de Rendimiento

### ✅ Implementadas:
- Critical CSS inline (elimina render-blocking)
- Font Awesome subset (solo 50KB vs 444KB)
- Lazy loading de imágenes e iframes
- Preload de recursos críticos
- Defer/Async de scripts
- Prefetch del siguiente capítulo
- Compresión HTML
- Cache headers optimizados

### 📈 Resultado Esperado:
- **PageSpeed Score**: 90-95 puntos
- **FCP**: <1.5s
- **LCP**: <2.0s
- **TBT**: <100ms

## 🔧 Menú Mejorado

El menú dropdown incluye:
- ✅ Delay de 300ms antes de cerrar (no se cierra tan rápido)
- ✅ Área de tolerancia invisible
- ✅ Transiciones suaves
- ✅ Fácil navegación entre opciones

## 📁 Estructura de Archivos

```
simpsons-online-theme/
│
├── style.css
├── functions.php
├── header.php
├── footer.php
├── sidebar.php
│
├── index.php
├── front-page.php
├── single.php ⭐ (reproductor de video)
├── page.php
├── archive.php
├── category.php
├── search.php
├── 404.php
│
├── inc/
│   └── optimizations.php (16 optimizaciones)
│
├── assets/
│   └── js/
│       └── main.js
│
└── README.md (este archivo)
```

## 🎯 Variables del Tema

```php
$folderName = "simpsons-online-theme"
$siteTitle = "Los Simpsons Online"
$themeName = "Simpsons Online Pro"
$textDomain = "simpsons-online"
```

## 📱 Responsive Design

Optimizado para:
- 📱 Móviles (< 640px)
- 📱 Tablets (640px - 1024px)
- 💻 Desktop (> 1024px)

## 🔍 Verificar SEO

### Rich Results Test:
```
https://search.google.com/test/rich-results
```
Verifica que Google detecte:
- ✅ VideoObject completo
- ✅ Keywords de Los Simpsons
- ✅ Personajes: Homer, Bart, Lisa, Marge, Maggie
- ✅ Creador: Matt Groening
- ✅ Productora: Fox

## 🐛 Solución de Problemas

### Reproductores no aparecen
→ Verifica que ACF esté activo y configurado correctamente

### Menú se cierra muy rápido
→ Ya está solucionado con delay de 300ms

### Colores se ven mal
→ Verifica que `style.css` se esté cargando correctamente

## 📄 Licencia

GNU General Public License v2 o posterior.
Los Simpsons es propiedad de Fox Broadcasting Company y Matt Groening.

## 🎉 Diferencias con Tema Dragon Ball

Este tema comparte la estructura pero está optimizado para:
- ✅ Colores amarillo Simpson (vs naranja Dragon Ball)
- ✅ Keywords "Los Simpsons" (vs "Dragon Ball")
- ✅ Personajes: Homer, Bart, Lisa (vs Goku, Vegeta)
- ✅ Icono TV (vs icono dragón)
- ✅ "Capítulos" y "Temporadas" (vs "Episodios" y "Sagas")

---

**¡Disfruta de tu tema Simpsons Online Pro optimizado!** 📺💛

*Versión 1.0.0 | 2025*

