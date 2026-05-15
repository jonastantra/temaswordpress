# 🐉 DB Online Pro - Tema WordPress para Dragon Ball Online

Tema personalizado optimizado para sitios web de episodios de Dragon Ball. Diseño moderno estilo AnimeFLV/JKAnime con excelente SEO y experiencia de usuario.

## 📋 Características Principales

### ✨ Diseño y Funcionalidad
- **Diseño Oscuro Moderno**: Optimizado para visualización de videos
- **Sistema de Reproductores**: 3 opciones de reproductor por episodio con pestañas
- **Responsive**: Perfectamente adaptado a móviles, tablets y escritorio
- **SEO Optimizado**: Schema markup, breadcrumbs, meta tags optimizados
- **Navegación Intuitiva**: Sistema de navegación entre episodios (anterior/siguiente)
- **Búsqueda Avanzada**: Buscador optimizado de episodios
- **Categorías por Sagas**: DB, DBZ, GT, Super, Kai, Héroes, Películas

### 🎨 Tecnologías Utilizadas
- **Tailwind CSS**: Framework CSS vía CDN
- **Font Awesome 6**: Iconos modernos
- **Google Fonts**: Poppins y Bangers
- **JavaScript Vanilla**: Sin dependencias de jQuery
- **ACF (Advanced Custom Fields)**: Para campos personalizados del reproductor

### 🎯 Características SEO
- Schema.org para videos
- Breadcrumbs optimizados
- URLs amigables
- Meta tags dinámicos
- Core Web Vitals optimizados
- Lazy loading de imágenes

## 📦 Requisitos

- **WordPress**: 5.0 o superior
- **PHP**: 7.4 o superior
- **Plugin requerido**: Advanced Custom Fields (ACF) - Versión gratuita

## 🚀 Instalación

### Paso 1: Instalar el Tema

1. Descarga todos los archivos del tema
2. Comprime la carpeta `dragonball-online-theme` en formato ZIP
3. En WordPress, ve a **Apariencia > Temas > Añadir nuevo**
4. Haz clic en **Subir tema** y selecciona el archivo ZIP
5. Haz clic en **Instalar ahora** y luego en **Activar**

**O manualmente vía FTP:**
1. Sube la carpeta completa a `/wp-content/themes/`
2. Ve a **Apariencia > Temas** en WordPress
3. Activa el tema "DB Online Pro"

### Paso 2: Instalar Plugin ACF

1. Ve a **Plugins > Añadir nuevo**
2. Busca "Advanced Custom Fields"
3. Instala y activa el plugin (versión gratuita)

### Paso 3: Configurar Campos ACF

1. Ve a **ACF > Grupos de campos > Añadir nuevo**
2. Título: "Reproductores de Episodios"
3. Agrega estos 3 campos:

**Campo 1:**
- Etiqueta: Player 1
- Nombre: player1
- Tipo: Área de texto (Textarea)

**Campo 2:**
- Etiqueta: Player 2
- Nombre: player2
- Tipo: Área de texto (Textarea)

**Campo 3:**
- Etiqueta: Player 3
- Nombre: player3
- Tipo: Área de texto (Textarea)

4. En **Ubicación**, configura:
   - Tipo de entrada = Entrada
   - es igual a = Todas

5. Guarda el grupo de campos

### Paso 4: Configurar Menús

1. Ve a **Apariencia > Menús**
2. Crea un nuevo menú llamado "Menú Principal"
3. Agrega las categorías/sagas que desees
4. Asigna a la ubicación **"Menú Principal"**
5. Crea otro menú para el footer (opcional)
6. Asigna a la ubicación **"Menú Footer"**

### Paso 5: Crear Categorías (Sagas)

Crea las siguientes categorías para organizar tus episodios:

- Dragon Ball
- Dragon Ball Z
- Dragon Ball GT
- Dragon Ball Super
- Dragon Ball Kai
- Dragon Ball Héroes
- Dragon Ball Películas

## 📝 Uso del Tema

### Crear un Episodio

1. Ve a **Entradas > Añadir nueva**
2. Título: Ej. "Dragon Ball Z Episodio 1 - La llegada de Raditz"
3. Contenido: Escribe la sinopsis del episodio
4. **Imagen destacada**: Sube un thumbnail del episodio (recomendado 800×450px)
5. **Categoría**: Selecciona la saga correspondiente (ej. Dragon Ball Z)

6. **Campos ACF** (parte inferior):
   - **Player 1**: Pega el código iframe del reproductor 1
   - **Player 2**: Pega el código iframe del reproductor 2 (opcional)
   - **Player 3**: Pega el código iframe del reproductor 3 (opcional)

Ejemplo de código iframe:
```html
<iframe src="https://tuprovedor.com/embed/video123" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
```

7. Publica el episodio

### Configuración de la Página de Inicio

1. Ve a **Páginas > Añadir nueva**
2. Título: "Inicio"
3. Publica la página (puede estar vacía)
4. Ve a **Ajustes > Lectura**
5. Selecciona "Una página estática"
6. Página de inicio: Selecciona "Inicio"
7. Guarda los cambios

## 🎨 Personalización

### Colores del Tema

Los colores principales están definidos en `style.css`:

```css
:root {
    --color-primary: #ff6b1a;      /* Naranja Dragon Ball */
    --color-secondary: #0066cc;     /* Azul */
    --color-dark: #0f0f0f;         /* Fondo oscuro */
    --color-dark-light: #1a1a1a;   /* Fondo secundario */
    --color-accent: #ffd700;        /* Dorado */
}
```

### Modificar Tipografía

Las fuentes están en `functions.php`:
- **Títulos**: Bangers (estilo Dragon Ball)
- **Cuerpo**: Poppins

### Widgets

El tema incluye áreas de widgets:
- **Sidebar Episodios**: Aparece en páginas de episodios
- **Footer Widget 1, 2, 3**: Aparecen en el footer

Ve a **Apariencia > Widgets** para configurarlos.

## 📁 Estructura de Archivos

```
dragonball-online-theme/
│
├── style.css              # Estilos principales del tema
├── functions.php          # Funcionalidades del tema
├── header.php            # Cabecera del sitio
├── footer.php            # Pie de página
├── sidebar.php           # Barra lateral
│
├── index.php             # Template por defecto
├── front-page.php        # Página de inicio
├── single.php            # Página de episodio individual ⭐
├── page.php              # Páginas estáticas
├── archive.php           # Archivo de posts
├── category.php          # Listado por categoría/saga
├── search.php            # Resultados de búsqueda
├── 404.php               # Página de error
│
├── assets/
│   └── js/
│       └── main.js       # JavaScript principal
│
├── README.md             # Este archivo
├── SCREENSHOT-DESCRIPTION.txt  # Guía para crear screenshot
└── screenshot.png        # Captura del tema (pendiente)
```

## 🔧 Optimizaciones Incluidas

### SEO
- ✅ Schema markup para videos
- ✅ Breadcrumbs optimizados
- ✅ Meta tags dinámicos
- ✅ Open Graph tags
- ✅ URLs amigables

### Performance
- ✅ Lazy loading de imágenes
- ✅ Scripts en el footer
- ✅ CSS/JS minificado
- ✅ Sin jQuery (JavaScript vanilla)
- ✅ Emojis deshabilitados
- ✅ jQuery Migrate removido

### UX
- ✅ Diseño responsive
- ✅ Menú móvil animado
- ✅ Header sticky
- ✅ Smooth scroll
- ✅ Animaciones suaves
- ✅ Cards con efectos hover

## 📱 Responsive Design

El tema está completamente optimizado para:
- 📱 Móviles (< 640px)
- 📱 Tablets (640px - 1024px)
- 💻 Desktop (> 1024px)

## 🐛 Solución de Problemas

### Los reproductores no aparecen
- Verifica que ACF esté instalado y activado
- Asegúrate de haber configurado los campos ACF correctamente
- Verifica que los campos se llamen exactamente: `player1`, `player2`, `player3`

### Las pestañas del reproductor no funcionan
- Verifica que el archivo `assets/js/main.js` esté cargando correctamente
- Revisa la consola del navegador en busca de errores JavaScript
- Asegúrate de que los iframes estén correctamente formateados

### Las imágenes no se muestran
- Verifica que las imágenes destacadas estén configuradas en cada post
- Regenera las miniaturas con un plugin como "Regenerate Thumbnails"

### El menú no aparece
- Ve a **Apariencia > Menús**
- Asegúrate de haber asignado el menú a "Menú Principal"

## 🎯 Variables de Configuración

Las variables definidas en las especificaciones:

```php
$folderName = "dragonball-online-theme"
$siteTitle = "Dragon Ball Online"
$themeName = "DB Online Pro"
$textDomain = "db-online"
```

## 📄 Licencia

Este tema está licenciado bajo GNU General Public License v2 o posterior.
Dragon Ball es propiedad de Toei Animation, Fuji TV y Akira Toriyama.

## 🤝 Soporte

Para soporte y consultas:
1. Revisa este README
2. Revisa la documentación de WordPress
3. Consulta la documentación de ACF

## 🔄 Actualizaciones Futuras

Mejoras planificadas:
- [ ] Sistema de calificación de episodios
- [ ] Lista de favoritos
- [ ] Modo claro/oscuro toggle
- [ ] Integración con redes sociales
- [ ] Sistema de comentarios mejorado
- [ ] PWA support

## 👨‍💻 Créditos

- **Tema creado por**: Equipo Dragon Ball Online
- **Framework CSS**: Tailwind CSS
- **Iconos**: Font Awesome 6
- **Fuentes**: Google Fonts (Poppins, Bangers)

---

## 📞 Información Adicional

- **Versión del Tema**: 1.0.0
- **Última actualización**: 2025
- **Compatible con**: WordPress 5.0+
- **Probado hasta**: WordPress 6.4

---

¡Disfruta de tu nuevo tema DB Online Pro! 🐉⚡

Si encuentras útil este tema, considera compartirlo con otros fanáticos de Dragon Ball.

