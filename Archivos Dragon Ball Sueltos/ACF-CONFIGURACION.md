# Configuración de Advanced Custom Fields (ACF)

## 📋 Guía Paso a Paso para Configurar ACF

Este archivo contiene las instrucciones detalladas para configurar los campos personalizados del reproductor de video.

---

## Paso 1: Instalar Advanced Custom Fields

1. En el panel de WordPress, ve a **Plugins > Añadir nuevo**
2. En el buscador, escribe: `Advanced Custom Fields`
3. Busca el plugin oficial (autor: WP Engine)
4. Haz clic en **Instalar ahora**
5. Una vez instalado, haz clic en **Activar**

**Nota**: Utiliza la versión GRATUITA. No necesitas la versión PRO para este tema.

---

## Paso 2: Crear Grupo de Campos

1. En el menú lateral, ve a **ACF > Grupos de campos**
2. Haz clic en **Añadir nuevo**

---

## Paso 3: Configurar el Grupo de Campos

### Configuración General

**Título del Grupo:**
```
Reproductores de Episodios
```

**Descripción (opcional):**
```
Campos para agregar hasta 3 opciones de reproductores de video por episodio
```

---

## Paso 4: Agregar los Campos

### Campo 1: Player 1 (Obligatorio)

Haz clic en **+ Añadir campo** y configura:

- **Etiqueta del campo**: `Player 1`
- **Nombre del campo**: `player1` (exactamente así, en minúsculas)
- **Tipo de campo**: `Área de texto` (Textarea)
- **Instrucciones**: `Pega aquí el código iframe del reproductor principal`
- **Obligatorio**: `Sí` ✅
- **Valor por defecto**: (dejar vacío)
- **Marcador de posición**: `<iframe src="..." ...></iframe>`
- **Número de filas**: `5`

### Campo 2: Player 2 (Opcional)

Haz clic en **+ Añadir campo** y configura:

- **Etiqueta del campo**: `Player 2`
- **Nombre del campo**: `player2` (exactamente así, en minúsculas)
- **Tipo de campo**: `Área de texto` (Textarea)
- **Instrucciones**: `Pega aquí el código iframe del reproductor alternativo (opcional)`
- **Obligatorio**: `No` ❌
- **Valor por defecto**: (dejar vacío)
- **Marcador de posición**: `<iframe src="..." ...></iframe>`
- **Número de filas**: `5`

### Campo 3: Player 3 (Opcional)

Haz clic en **+ Añadir campo** y configura:

- **Etiqueta del campo**: `Player 3`
- **Nombre del campo**: `player3` (exactamente así, en minúsculas)
- **Tipo de campo**: `Área de texto` (Textarea)
- **Instrucciones**: `Pega aquí el código iframe del tercer reproductor (opcional)`
- **Obligatorio**: `No` ❌
- **Valor por defecto**: (dejar vacío)
- **Marcador de posición**: `<iframe src="..." ...></iframe>`
- **Número de filas**: `5`

---

## Paso 5: Configurar Ubicación

Desplázate hacia abajo hasta la sección **Ubicación**.

**Regla de Ubicación:**
- **Mostrar este grupo de campos si:**
  - Tipo de entrada
  - es igual a
  - Entrada (Post)

**Configuración visual:**
```
Tipo de entrada | es igual a | Entrada
```

Esto hará que los campos aparezcan en todas las entradas (posts/episodios).

---

## Paso 6: Configurar Opciones

En la sección **Opciones** (parte inferior), configura:

### Presentación:
- **Estilo**: `Estándar (WP metabox)`
- **Posición**: `Normal (después del contenido)`
- **Orden**: `0`

### Opciones:
- ✅ **Mostrar en pantalla de edición**: Activado
- ✅ **Mostrar en REST API**: Activado (para compatibilidad futura)

---

## Paso 7: Guardar

1. Haz clic en **Publicar** o **Actualizar** en la parte superior derecha
2. Los campos ya estarán disponibles en tus posts

---

## ✅ Verificación de la Configuración

Para verificar que todo funciona correctamente:

1. Ve a **Entradas > Añadir nueva**
2. Desplázate hacia abajo después del editor de contenido
3. Deberías ver una caja llamada **"Reproductores de Episodios"**
4. Dentro deberías ver tres campos:
   - Player 1 (con asterisco rojo - obligatorio)
   - Player 2 (opcional)
   - Player 3 (opcional)

---

## 📝 Cómo Usar los Campos

### Ejemplo de Código de Reproductor

Cuando agregues un episodio, pega el código iframe en cada campo:

**Ejemplo básico:**
```html
<iframe src="https://tu-proveedor.com/embed/video123" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
```

**Ejemplo con más opciones:**
```html
<iframe src="https://streamtape.com/e/video123" width="100%" height="100%" frameborder="0" scrolling="no" allowfullscreen allowtransparency allow="autoplay"></iframe>
```

### Proveedores Comunes de Video

Los campos funcionan con cualquier proveedor que ofrezca código embed/iframe:
- Streamtape
- Fembed
- Voe
- Doodstream
- Mixdrop
- Streamlare
- Y cualquier otro con código iframe

---

## 🔧 Solución de Problemas

### Los campos no aparecen en mis posts
- Verifica que ACF esté activado
- Verifica que la regla de ubicación esté configurada como "Entrada"
- Prueba editando un post existente
- Limpia la caché del navegador

### Los reproductores no se muestran en el sitio
- Verifica que hayas pegado código válido en al menos `player1`
- Verifica que el código incluya las etiquetas `<iframe>`
- Verifica que el proveedor de video permita embeds
- Revisa la consola del navegador por errores

### Error: "get_field() function not found"
- Esto significa que ACF no está activado
- Ve a **Plugins** y activa "Advanced Custom Fields"

---

## 📊 Configuración JSON (Importación Rápida)

Si prefieres importar la configuración, usa este JSON:

```json
{
    "key": "group_reproductores_episodios",
    "title": "Reproductores de Episodios",
    "fields": [
        {
            "key": "field_player1",
            "label": "Player 1",
            "name": "player1",
            "type": "textarea",
            "instructions": "Pega aquí el código iframe del reproductor principal",
            "required": 1,
            "rows": 5,
            "placeholder": "<iframe src=\"...\" ...><\/iframe>"
        },
        {
            "key": "field_player2",
            "label": "Player 2",
            "name": "player2",
            "type": "textarea",
            "instructions": "Pega aquí el código iframe del reproductor alternativo (opcional)",
            "required": 0,
            "rows": 5,
            "placeholder": "<iframe src=\"...\" ...><\/iframe>"
        },
        {
            "key": "field_player3",
            "label": "Player 3",
            "name": "player3",
            "type": "textarea",
            "instructions": "Pega aquí el código iframe del tercer reproductor (opcional)",
            "required": 0,
            "rows": 5,
            "placeholder": "<iframe src=\"...\" ...><\/iframe>"
        }
    ],
    "location": [
        [
            {
                "param": "post_type",
                "operator": "==",
                "value": "post"
            }
        ]
    ],
    "menu_order": 0,
    "position": "normal",
    "style": "default"
}
```

### Cómo importar el JSON:

1. Ve a **ACF > Herramientas**
2. Pestaña **Importar grupos de campos**
3. Copia y pega el JSON anterior
4. Haz clic en **Importar archivo JSON**

---

## ✨ Consejos Adicionales

### Mejores Prácticas:
- ✅ Siempre completa al menos el `Player 1`
- ✅ Usa reproductores de diferentes proveedores para redundancia
- ✅ Verifica que los iframes funcionen antes de publicar
- ✅ Mantén el código iframe limpio (sin espacios extra)

### Seguridad:
- ✅ Usa solo proveedores confiables
- ✅ Verifica que los iframes usen HTTPS
- ✅ No pegues código JavaScript arbitrario, solo iframes

---

## 📞 Soporte

Si tienes problemas con ACF:
- Documentación oficial: https://www.advancedcustomfields.com/resources/
- Foros de soporte: https://support.advancedcustomfields.com/

---

¡Configuración completada! Ahora puedes empezar a agregar episodios con reproductores de video. 🎬🐉

