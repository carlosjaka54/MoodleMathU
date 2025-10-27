# 🚨 SOLUCIÓN: Modal no aparece - Guía Paso a Paso

## ❓ ¿Por qué no aparece?

Posibles causas:
1. ❌ No pegaste el código completo
2. ❌ Lo pegaste en el lugar incorrecto
3. ❌ No estás viendo la página de inicio
4. ❌ El bloque está oculto
5. ❌ Hay errores de JavaScript

---

## ✅ SOLUCIÓN RÁPIDA - 5 Pasos Exactos

### 📍 **PASO 1: Verifica que estás en la página correcta**

1. Ve a la **URL principal** de tu Moodle, ejemplo:
   - `http://localhost/moodle/`
   - `https://tumoodle.com/`
   - NO debe ser `/course/view.php?id=X`

2. Debes ver:
   - El logo de tu institución
   - Enlaces a categorías/cursos
   - La página principal (frontpage)

---

### 📍 **PASO 2: Usa el archivo de prueba primero**

1. **PRIMERO** usa `modal-video-TEST.html` (el que acabo de crear)
2. Este archivo tiene:
   - ✅ Mensajes de confirmación visibles
   - ✅ Consola de debug
   - ✅ Código simplificado

---

### 📍 **PASO 3: Método de instalación EXACTO**

#### **Opción A: Bloque HTML (MÁS FÁCIL)**

1. **Ir a la página de inicio:**
   - Haz clic en el logo/nombre del sitio
   - O escribe la URL principal

2. **Activar modo edición:**
   - Busca botón "Activar edición" (esquina superior derecha)
   - O en el menú de engranaje → "Activar edición"

3. **Agregar bloque HTML:**
   - En la barra lateral, busca "Agregar un bloque"
   - Haz clic en "Agregar un bloque"
   - Selecciona **"HTML"** de la lista

4. **Configurar el bloque:**
   - Haz clic en el ícono de **engranaje** (⚙️) del nuevo bloque
   - O haz clic en "Configurar bloque HTML"

5. **Pegar el código:**
   ```
   Campo: "Título del bloque"
   → Déjalo VACÍO o pon "Video"
   
   Campo: "Contenido"
   → AQUÍ pega TODO el código de modal-video-TEST.html
   → Usa Ctrl+A para seleccionar todo
   → Usa Ctrl+C para copiar
   → Usa Ctrl+V para pegar
   ```

6. **IMPORTANTE - Configurar visibilidad:**
   - Busca la sección **"¿Dónde puede aparecer este bloque?"**
   - Selecciona: **"Página principal del sitio"** o **"Cualquier página"**

7. **Guardar:**
   - Haz clic en **"Guardar cambios"**

8. **Desactivar edición:**
   - Haz clic en "Desactivar edición"

9. **Verificar:**
   - ✅ Debes ver un mensaje verde que dice "El código está funcionando"
   - ✅ Debes ver un botón verde que dice "VER VIDEO INFORMATIVO"
   - ✅ Debes ver un mensaje azul de debug

---

#### **Opción B: Additional HTML**

1. **Ir a configuración del tema:**
   ```
   Administración del sitio 
   → Apariencia 
   → Temas 
   → Configuración del tema (Theme settings)
   ```

2. **Buscar "Additional HTML":**
   - Scroll hacia abajo
   - Busca la sección llamada **"Additional HTML"**

3. **Pegar en el campo correcto:**
   ```
   Campo: "When BODY is opened" ← NO aquí
   Campo: "When BODY is being finished" ← SÍ AQUÍ ✅
   ```

4. **Pegar TODO el código:**
   - Abre `modal-video-TEST.html`
   - Selecciona TODO (Ctrl+A)
   - Copia (Ctrl+C)
   - Pega en el campo (Ctrl+V)

5. **Guardar cambios:**
   - Haz clic en "Guardar cambios"

6. **Limpiar caché:**
   ```
   Administración del sitio 
   → Desarrollo 
   → Purgar cachés
   → "Purgar todas las cachés"
   ```

7. **Verificar:**
   - Ve a la página de inicio
   - Debes ver el mensaje verde y el botón

---

### 📍 **PASO 4: Verificar con la consola**

1. **Abrir consola del navegador:**
   - Windows/Linux: `F12` o `Ctrl+Shift+I`
   - Mac: `Cmd+Option+I`

2. **Ir a la pestaña "Console"**

3. **Buscar mensajes:**
   - ✅ Debes ver: `🎬 Script del modal cargado`
   - ✅ Debes ver: `✅ Modal inicializado correctamente`
   - ❌ Si ves errores rojos, cópialos

4. **Si no ves NINGÚN mensaje:**
   - El código NO se cargó
   - Revisa que lo pegaste en el lugar correcto

---

### 📍 **PASO 5: Probar el modal**

1. **Hacer clic en el botón verde**
2. **Observar la consola:**
   - Debes ver: `👆 Clic en botón abrir`
   - Debes ver: `📂 Abriendo modal...`
   - Debes ver: `✅ Modal abierto`

3. **El modal debe:**
   - ✅ Aparecer con fondo oscuro
   - ✅ Mostrar el video
   - ✅ Reproducirse automáticamente

4. **Cerrar con:**
   - Botón X (debes ver: `👆 Clic en botón cerrar`)
   - Tecla Esc (debes ver: `⌨️ Tecla Escape presionada`)
   - Clic fuera (debes ver: `👆 Clic fuera del modal`)

---

## 🔍 DIAGNÓSTICO DE PROBLEMAS

### Problema 1: "No veo el mensaje verde ni el botón"

**Causa:** El código no se cargó

**Solución:**
1. Verifica que estés en la página de INICIO (no en un curso)
2. Revisa que pegaste TODO el código (debe empezar con `<!--` y terminar con `</div>`)
3. Si usaste bloque HTML, verifica que la "visibilidad" esté en "Página principal"
4. Limpia la caché del navegador (Ctrl+F5)

---

### Problema 2: "Veo el mensaje verde pero no el botón"

**Causa:** El HTML se cargó pero falta algo

**Solución:**
1. Abre la consola (F12)
2. Busca mensajes de error rojos
3. Asegúrate de haber pegado TODO el código sin modificar nada

---

### Problema 3: "Veo el botón pero al hacer clic no pasa nada"

**Causa:** El JavaScript no se ejecutó

**Solución:**
1. Abre la consola (F12)
2. ¿Ves `🎬 Script del modal cargado`?
   - NO → El script no se cargó, pega el código completo de nuevo
   - SÍ → Continúa
3. Haz clic en el botón y mira la consola
4. ¿Ves `👆 Clic en botón abrir`?
   - NO → Hay un problema con el evento, recarga la página
   - SÍ → El modal debería abrirse

---

### Problema 4: "El modal se abre pero no hay video"

**Causa:** Problema con YouTube

**Solución:**
1. Verifica tu conexión a Internet
2. Verifica que YouTube no esté bloqueado
3. Abre la consola y busca errores relacionados con iframe
4. Prueba el video directamente: https://youtu.be/nnQHxEnq6Go

---

### Problema 5: "Veo errores en la consola"

**Errores comunes y soluciones:**

```
Error: "Uncaught TypeError: Cannot read property 'addEventListener'"
→ El elemento no existe, verifica el ID del botón

Error: "Refused to display in a frame because it set 'X-Frame-Options'"
→ El video no permite embed, cambia la URL del video

Error: "Content Security Policy"
→ Tu Moodle bloquea iframes, contacta al administrador
```

---

## 📋 CHECKLIST DE VERIFICACIÓN

Marca cada paso:

- [ ] Estoy en la página de INICIO de Moodle (URL principal)
- [ ] Activé el modo de edición
- [ ] Agregué un bloque HTML O usé Additional HTML
- [ ] Pegué TODO el código de `modal-video-TEST.html`
- [ ] Configuré visibilidad en "Página principal del sitio"
- [ ] Guardé los cambios
- [ ] Desactivé el modo de edición
- [ ] Veo el mensaje verde "✅ El código está funcionando"
- [ ] Veo el botón verde "VER VIDEO INFORMATIVO"
- [ ] Veo el mensaje azul de debug
- [ ] Abrí la consola (F12) y veo mensajes con 🎬
- [ ] Hice clic en el botón y el modal se abre
- [ ] El video se reproduce
- [ ] Puedo cerrar con X, Esc o clic fuera

---

## 🎬 VIDEO TUTORIAL (Si necesitas)

Si sigues teniendo problemas, necesito que me digas:

1. **¿Qué ves en la página?**
   - Nada
   - Solo mensaje verde
   - Mensaje verde + botón
   - Todo pero el modal no abre

2. **¿Qué dice la consola? (F12)**
   - Copia los mensajes que aparecen

3. **¿Qué método usaste?**
   - Bloque HTML
   - Additional HTML

4. **Captura de pantalla**
   - De la página donde debería aparecer
   - De la configuración del bloque

---

## ✅ UNA VEZ QUE FUNCIONE

Cuando el archivo de prueba funcione correctamente:

1. **Reemplaza** el código de `modal-video-TEST.html`
2. **Por** el código de `modal-video-moodle.html` (la versión final)
3. Esto quitará los mensajes de debug
4. Y tendrá el diseño final profesional

---

## 🆘 ÚLTIMO RECURSO

Si NADA funciona, prueba esto:

1. Crea una NUEVA PÁGINA en Moodle
2. Agrega un bloque HTML ahí
3. Pega el código
4. Si funciona ahí → El problema es con la página de inicio
5. Si NO funciona → El problema es con Moodle/navegador

---

**🎯 Objetivo:** Ver el mensaje verde, el botón y que el modal funcione.

**📞 Si necesitas ayuda:** Mándame una captura de:
1. La página donde pegaste el código
2. La consola del navegador (F12)
3. El mensaje de error exacto
