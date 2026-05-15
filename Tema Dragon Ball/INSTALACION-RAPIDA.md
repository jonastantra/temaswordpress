# 🚀 Guía de Instalación Rápida - DB Online Pro

## Resumen Express - 5 Minutos

Esta guía te ayudará a tener tu tema funcionando en menos de 5 minutos.

---

## ✅ Checklist Pre-Instalación

Antes de comenzar, asegúrate de tener:
- [ ] WordPress 5.0+ instalado y funcionando
- [ ] Acceso al panel de administración
- [ ] Archivos del tema descargados

---

## 📦 Instalación en 5 Pasos

### Paso 1: Subir el Tema (2 minutos)

**Opción A - Via Panel de WordPress:**
1. Panel de WordPress → **Apariencia** → **Temas**
2. Clic en **Añadir nuevo**
3. Clic en **Subir tema**
4. Selecciona el archivo `dragonball-online-theme.zip`
5. Clic en **Instalar ahora**
6. Clic en **Activar**

**Opción B - Via FTP:**
1. Conecta por FTP a tu servidor
2. Navega a `/wp-content/themes/`
3. Sube la carpeta `dragonball-online-theme`
4. En WordPress → **Apariencia** → **Temas**
5. Activa "DB Online Pro"

---

### Paso 2: Instalar Advanced Custom Fields (1 minuto)

1. **Plugins** → **Añadir nuevo**
2. Buscar: `Advanced Custom Fields`
3. **Instalar ahora** (plugin oficial de WP Engine)
4. **Activar**

---

### Paso 3: Configurar Campos ACF (1 minuto)

1. **ACF** → **Grupos de campos** → **Añadir nuevo**
2. Título: `Reproductores de Episodios`
3. Añadir 3 campos tipo "Área de texto":
   - Nombre: `player1` (obligatorio)
   - Nombre: `player2` (opcional)
   - Nombre: `player3` (opcional)
4. Ubicación: `Tipo de entrada = Entrada`
5. **Publicar**

> 💡 **Tip**: Consulta `ACF-CONFIGURACION.md` para instrucciones detalladas

---

### Paso 4: Crear Categorías (30 segundos)

**Entradas** → **Categorías** → Crear estas categorías:
- Dragon Ball
- Dragon Ball Z
- Dragon Ball GT
- Dragon Ball Super
- Dragon Ball Kai
- Dragon Ball Héroes
- Dragon Ball Películas

---

### Paso 5: Configurar Menús (30 segundos)

1. **Apariencia** → **Menús** → **Crear nuevo menú**
2. Nombre: `Menú Principal`
3. Agregar las categorías creadas
4. Guardar menú
5. Asignar a ubicación: **Menú Principal**

---

## 🎬 Crear tu Primer Episodio

1. **Entradas** → **Añadir nueva**
2. **Título**: `Dragon Ball Z Episodio 1 - La llegada de Raditz`
3. **Contenido**: Escribe la sinopsis
4. **Imagen destacada**: Sube un thumbnail
5. **Categoría**: Selecciona "Dragon Ball Z"
6. **Scroll abajo** → Campos "Reproductores de Episodios"
7. **Player 1**: Pega código iframe:
   ```html
   <iframe src="TU_URL_AQUI" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
   ```
8. **Publicar**

---

## 🏠 Configurar Página de Inicio

1. **Páginas** → **Añadir nueva**
2. Título: `Inicio`
3. **Publicar** (puede estar vacía)
4. **Ajustes** → **Lectura**
5. Seleccionar: "Una página estática"
6. Página de inicio: `Inicio`
7. **Guardar cambios**

---

## ✨ ¡Listo! Tu Sitio Está Funcionando

Tu tema ahora debería estar completamente operativo con:
- ✅ Diseño oscuro moderno
- ✅ Sistema de reproductores con pestañas
- ✅ Navegación por sagas
- ✅ Búsqueda de episodios
- ✅ Responsive design

---

## 🎨 Personalización Rápida

### Cambiar Colores
Edita `style.css` líneas 30-38:
```css
:root {
    --color-primary: #ff6b1a;    /* Cambia este color */
    --color-secondary: #0066cc;   /* Y este también */
}
```

### Cambiar Nombre del Sitio
**Ajustes** → **Generales** → Título del sitio

### Cambiar Logo
El logo actual usa un icono de Font Awesome (🐉).
Para cambiarlo, edita `header.php` línea 17.

---

## 🔧 Verificación Post-Instalación

Verifica que todo funcione:
- [ ] El tema está activo en **Apariencia** → **Temas**
- [ ] ACF está instalado y activo en **Plugins**
- [ ] Los campos ACF aparecen al editar una entrada
- [ ] Las categorías están creadas
- [ ] El menú principal está configurado
- [ ] La página de inicio está configurada

---

## 📊 Estructura Recomendada de Contenido

```
Tu Sitio
│
├── Inicio (Página estática)
│
├── Categorías
│   ├── Dragon Ball (10+ episodios)
│   ├── Dragon Ball Z (50+ episodios)
│   ├── Dragon Ball GT (20+ episodios)
│   └── ...
│
└── Menú
    ├── Inicio
    ├── Dragon Ball
    ├── Dragon Ball Z
    ├── Dragon Ball GT
    └── ...
```

---

## 🚨 Solución Rápida de Problemas

### El reproductor no aparece
→ Verifica que ACF esté activo y los campos configurados

### Las pestañas no funcionan
→ Limpia la caché del navegador y verifica `main.js`

### El menú no se muestra
→ Asegúrate de asignar el menú a "Menú Principal"

### Las imágenes no cargan
→ Verifica permisos de la carpeta `/wp-content/uploads/`

### Página en blanco
→ Activa el modo debug en `wp-config.php`:
```php
define('WP_DEBUG', true);
```

---

## 📚 Archivos de Documentación

- **README.md** - Documentación completa
- **ACF-CONFIGURACION.md** - Guía detallada de ACF
- **SCREENSHOT-DESCRIPTION.txt** - Cómo crear el screenshot
- **INSTALACION-RAPIDA.md** - Este archivo

---

## 🎯 Próximos Pasos

1. **Agrega más episodios** - Crea al menos 10-20 para probar la paginación
2. **Configura SEO** - Instala Yoast SEO o Rank Math
3. **Optimiza imágenes** - Usa WebP y lazy loading
4. **Configura caché** - Instala WP Super Cache o W3 Total Cache
5. **Backups** - Configura backups automáticos con UpdraftPlus

---

## 💡 Tips Pro

### Mejorar SEO:
- Usa títulos descriptivos: "Dragon Ball Z Episodio 1 - [Nombre]"
- Rellena las sinopsis con al menos 100 palabras
- Usa imágenes optimizadas (WebP, <200KB)

### Mejorar Velocidad:
- Instala un plugin de caché
- Optimiza la base de datos
- Usa un CDN (Cloudflare gratis)
- Comprime imágenes antes de subirlas

### Mejorar UX:
- Organiza episodios en orden cronológico
- Usa miniaturas de buena calidad
- Mantén al menos 2 opciones de reproductor por episodio
- Responde a los comentarios

---

## 📞 Recursos Adicionales

- **WordPress Codex**: https://codex.wordpress.org/
- **ACF Docs**: https://www.advancedcustomfields.com/resources/
- **Tailwind CSS**: https://tailwindcss.com/docs
- **Font Awesome**: https://fontawesome.com/icons

---

## ✉️ Soporte

¿Necesitas ayuda adicional?
1. Revisa `README.md` para documentación completa
2. Revisa `ACF-CONFIGURACION.md` para problemas con campos
3. Consulta los foros de WordPress
4. Revisa la consola del navegador para errores JavaScript

---

## 🎉 ¡Felicidades!

Tu sitio de Dragon Ball Online está listo para recibir visitantes.

**Recuerda**:
- Mantén WordPress actualizado
- Haz backups regulares
- Monitorea el rendimiento
- Escucha el feedback de tus usuarios

---

**¡Que disfrutes tu nuevo tema DB Online Pro!** 🐉⚡

---

*Tema creado con ❤️ para los fans de Dragon Ball*
*Versión 1.0.0 | 2025*

