# Guía de Configuración - Diseño de Cursos y Categorías
## Universidad del Putumayo - Moodle

---

## 📋 ÍNDICE
1. [Configuración de la Vista de Cursos](#1-configuración-de-la-vista-de-cursos)
2. [Agregar Imágenes a los Cursos](#2-agregar-imágenes-a-los-cursos)
3. [Configuración de Categorías](#3-configuración-de-categorías)
4. [Aplicar los Estilos CSS](#4-aplicar-los-estilos-css)
5. [Verificación Final](#5-verificación-final)

---

## 1. CONFIGURACIÓN DE LA VISTA DE CURSOS

### Paso 1.1: Configurar la Portada
1. Inicia sesión como **Administrador**
2. Ve a: **Administración del sitio** → **Portada** → **Ajustes de la portada**
3. Configura lo siguiente:

   **Elementos de la portada:**
   - Selecciona: `Lista de cursos` o `Cursos disponibles`
   - Orden: Pon este elemento primero

   **Formato del listado de cursos (frontpagecoursedisplay):**
   - Selecciona: `Tarjetas de cursos` (Course boxes)

4. Guarda los cambios

### Paso 1.2: Configurar la Vista de Categorías de Cursos
1. Ve a: **Administración del sitio** → **Cursos** → **Vista de categorías de cursos**
2. Configura:
   - **Formato de listado de cursos:** `Tarjetas` o `Bloques de cursos`
   - **Cursos por página:** `12` (o el número que prefieras)
   - **Mostrar descripción del curso:** `Sí`
   - **Mostrar imagen del curso:** `Sí`

---

## 2. AGREGAR IMÁGENES A LOS CURSOS

### Diseño de Imagen Recomendado
- **Dimensiones:** 600x400 píxeles (mínimo)
- **Formato:** JPG o PNG
- **Color de fondo:** Verde (#7CB342 o #8BC34A) con degradado diagonal
- **Ícono:** Blanco, centrado, con sombra diagonal

### Paso 2.1: Subir Imagen a un Curso
1. Ve al **curso** que deseas configurar
2. Haz clic en el **ícono de engranaje** ⚙️ → **Editar ajustes**
3. Baja hasta la sección **"Imagen del curso"**
4. Arrastra o selecciona la imagen
5. Guarda los cambios

### Paso 2.2: Crear Imágenes Verdes con Ícono (Opcional)
Si necesitas crear las imágenes con el diseño verde:

**Opción A: Usar Canva o Photoshop**
- Tamaño: 600x400px
- Fondo: Degradado verde (de #7CB342 a #8BC34A en diagonal)
- Agregar ícono blanco de cámara o documento al centro
- Agregar sombra diagonal oscura en la esquina inferior derecha

**Opción B: Usar CSS (Ya incluido en los estilos)**
- Los estilos CSS que agregamos automáticamente crearán el efecto verde
- Solo necesitas subir una imagen base (puede ser cualquier imagen)

---

## 3. CONFIGURACIÓN DE CATEGORÍAS

### Paso 3.1: Estructura de Categorías Recomendada
```
📁 SEDE MOCOA
   └─ 📂 FACULTAD DE INGENIERÍAS Y CIENCIAS BÁSICAS
   └─ 📂 FACULTAD DE ADMINISTRACIÓN, CIENCIAS CONTABLES Y ECONÓMICAS
   └─ 📂 FACULTAD DE POSGRADOS
   └─ 📂 DIPLOMADOS
   └─ 📂 CURSOS DE EXTENSIÓN

📁 SEDE SIBUNDOY
   └─ 📂 FACULTAD DE INGENIERÍAS Y CIENCIAS BÁSICAS
   └─ 📂 FACULTAD DE ADMINISTRACIÓN, CIENCIAS CONTABLES Y ECONÓMICAS

📁 SEDE PUERTO ASÍS
   └─ 📂 [Facultades correspondientes]
```

### Paso 3.2: Crear Categorías Principales (Sedes)
1. Ve a: **Administración del sitio** → **Cursos** → **Gestionar cursos y categorías**
2. Haz clic en **"Crear nueva categoría"**
3. Configura:
   - **Nombre:** SEDE MOCOA
   - **Categoría padre:** Nivel Superior
   - **Descripción:** (opcional) Información sobre la sede
   - **Visible:** Sí
4. Guarda y repite para:
   - SEDE SIBUNDOY
   - SEDE PUERTO ASÍS

### Paso 3.3: Crear Subcategorías (Facultades)
1. Selecciona la categoría padre (ej: SEDE MOCOA)
2. Haz clic en **"Crear nueva categoría"**
3. Configura:
   - **Nombre:** FACULTAD DE INGENIERÍAS Y CIENCIAS BÁSICAS
   - **Categoría padre:** SEDE MOCOA
   - **Visible:** Sí
4. Guarda y repite para todas las facultades

### Paso 3.4: Asignar Cursos a Categorías
1. Ve al curso que deseas asignar
2. **Editar ajustes** → **Categoría del curso**
3. Selecciona la categoría correspondiente
4. Guarda cambios

---

## 4. APLICAR LOS ESTILOS CSS

### ⚠️ IMPORTANTE: Los archivos ya están creados
Los archivos SCSS personalizados ya fueron creados y agregados:
- ✅ `course-cards-custom.scss`
- ✅ `category-list-custom.scss`
- ✅ Importaciones agregadas en `moodle.scss`

### Paso 4.1: Purgar Cachés de Moodle
1. Ve a: **Administración del sitio** → **Desarrollo** → **Purgar todas las cachés**
2. Haz clic en **"Purgar todas las cachés"**
3. Espera a que termine el proceso

### Paso 4.2: Recompilar el Tema (Si no se ven los cambios)
1. Ve a: **Administración del sitio** → **Apariencia** → **Temas**
2. Haz clic en el tema **Boost** que estás usando
3. Si hay una opción de "Recompilar tema" o "Reset theme cache", úsala
4. Alternativamente, ve a: **Administración del sitio** → **Desarrollo** → **Reconstruir el caché de temas**

### Paso 4.3: Verificar en Navegador
1. Cierra completamente el navegador
2. Abre el navegador en modo incógnito
3. Accede a la portada de Moodle
4. Verifica que los cursos se vean con tarjetas verdes
5. Ve a la página de categorías y verifica el diseño

---

## 5. VERIFICACIÓN FINAL

### ✅ Checklist de Verificación

**Cursos:**
- [ ] Los cursos se muestran en formato de tarjetas
- [ ] Las tarjetas tienen fondo verde con degradado
- [ ] Hay efecto de sombra diagonal en las imágenes
- [ ] Al pasar el mouse, las tarjetas se elevan ligeramente
- [ ] El título del curso está centrado debajo de la imagen

**Categorías:**
- [ ] Las categorías principales (sedes) tienen ícono verde ✓
- [ ] Las subcategorías (facultades) tienen flecha ➤
- [ ] Al pasar el mouse, se resalta la categoría
- [ ] Se muestra el contador de cursos entre paréntesis
- [ ] El título "Categorías" tiene fondo verde claro

**General:**
- [ ] No hay errores en la consola del navegador
- [ ] La navegación funciona correctamente
- [ ] El diseño es responsive (se ve bien en móvil)

---

## 🎨 PERSONALIZACIÓN ADICIONAL

### Cambiar los Colores Verde
Si deseas cambiar el tono de verde:

1. Edita el archivo: `theme/boost/scss/course-cards-custom.scss`
2. Busca: `#7CB342` y `#8BC34A`
3. Reemplaza con tus colores preferidos
4. Purga el caché de Moodle

### Ajustar Tamaños de las Tarjetas
En el mismo archivo `course-cards-custom.scss`:
- Busca: `height: 200px;` (altura de la imagen)
- Ajusta según tu preferencia

---

## 🆘 SOLUCIÓN DE PROBLEMAS

### Problema: No se ven los cambios CSS
**Solución:**
1. Purga todas las cachés de Moodle
2. Limpia el caché del navegador (Ctrl+Shift+Del)
3. Abre en modo incógnito
4. Verifica que los archivos SCSS estén en la ubicación correcta

### Problema: Las imágenes no se muestran
**Solución:**
1. Verifica que subiste las imágenes en **Editar ajustes** del curso
2. Asegúrate de que la opción "Mostrar imagen del curso" esté activada
3. Las imágenes deben tener permisos de lectura

### Problema: El diseño no es responsive
**Solución:**
- Los estilos incluyen media queries para móvil
- Purga el caché y verifica de nuevo
- Si persiste, revisa la consola del navegador para errores

---

## 📞 NOTAS FINALES

- **Backup:** Siempre haz backup antes de subir a producción
- **Pruebas:** Prueba primero en un entorno de desarrollo
- **Caché:** Recuerda purgar el caché después de cada cambio
- **Responsive:** Verifica el diseño en diferentes dispositivos

---

**Última actualización:** Octubre 2025  
**Versión:** 1.0  
**Tema:** Boost (Moodle)
