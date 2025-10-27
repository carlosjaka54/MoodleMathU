# 🎥 Modal de Video - Integrado en el Tema

## ✅ ¿Qué se hizo?

El modal de video se integró directamente en el archivo `footer.mustache` del tema Boost.

**Archivo modificado:**
- `/theme/boost/templates/footer.mustache`

## 🎯 Cómo funciona

1. **Detección automática**: El modal solo aparece en la página de inicio
2. **Carga diferida**: Aparece 2 segundos después de cargar la página
3. **Una vez por día**: Usa localStorage para no mostrar el mismo día
4. **Video de YouTube**: `https://youtu.be/nnQHxEnq6Go`

## 🚀 Para aplicar los cambios

```bash
cd /Users/savimbo/Documents/temp/MoodleMathU
./limpiar-cache.sh
```

O manualmente:
1. Ve a **Administración del sitio** → **Desarrollo** → **Purgar cachés**
2. Haz clic en **"Purgar todas las cachés"**

## 🧪 Para probar

1. **Ve a la página de inicio** de tu Moodle
2. **Espera 2 segundos**
3. **El modal debe aparecer** automáticamente

### Si no aparece:
- Abre la consola (F12)
- Ejecuta: `localStorage.removeItem('video_modal_visto')`
- Recarga la página (F5)

## 🎬 Características del Modal

✅ **Aparece automáticamente** en la página de inicio  
✅ **Video con autoplay** (se reproduce solo)  
✅ **Responsive** (funciona en móviles)  
✅ **Cerrar con:**
   - Botón X
   - Tecla Escape
   - Clic fuera del modal  
✅ **Memoria diaria** (no molesta al usuario)

## 🔧 Personalización

### Cambiar el video
Edita `footer.mustache` línea ~152:
```javascript
iframe.src = 'https://www.youtube.com/embed/TU_VIDEO_ID?autoplay=1&rel=0';
```

### Cambiar el tiempo de aparición
Edita `footer.mustache` línea ~146:
```javascript
setTimeout(function() {
    // ...
}, 2000); // ← Milisegundos (2000 = 2 segundos)
```

### Cambiar el título
Edita `footer.mustache` línea ~125:
```html
<h3>📹 Tu Título Aquí</h3>
```

### Desactivar el modal temporalmente
Comenta las líneas 121-198 en `footer.mustache`:
```mustache
{{!
    ... todo el código del modal ...
}}
```

## 📱 Compatibilidad

- ✅ Chrome, Firefox, Safari, Edge
- ✅ Dispositivos móviles
- ✅ Tablets
- ✅ Navegación por teclado

## 🐛 Solución de Problemas

### El modal no aparece
1. Limpia la caché de Moodle
2. Verifica que estés en la página de INICIO (no en un curso)
3. Espera 2-3 segundos
4. Abre consola (F12) y busca mensajes

### El modal aparece en todas las páginas
- Revisa que la condición en línea 138 esté correcta
- Solo debe mostrarse en páginas con clase `pagelayout-frontpage`

### El video no se reproduce
- Verifica tu conexión a Internet
- Confirma que el video sea público en YouTube
- Revisa bloqueadores de anuncios

## 📊 Logs

Para ver si funciona, abre la consola (F12) y busca:
- `✅ Modal de video mostrado` - Cuando se abre
- `✅ Modal cerrado` - Cuando se cierra

---

**✨ ¡Listo!** El modal está integrado directamente en tu tema y funcionará automáticamente.
