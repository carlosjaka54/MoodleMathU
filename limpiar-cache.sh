#!/bin/bash

echo "🧹 Limpiando caché de Moodle..."
echo ""

# Encontrar PHP
if command -v php >/dev/null 2>&1; then
    PHP="php"
elif [ -f "/opt/homebrew/bin/php" ]; then
    PHP="/opt/homebrew/bin/php"
elif [ -f "/usr/local/bin/php" ]; then
    PHP="/usr/local/bin/php"
else
    echo "❌ No se encontró PHP"
    echo ""
    echo "💡 Limpia la caché manualmente:"
    echo "   Administración → Desarrollo → Purgar cachés"
    exit 1
fi

# Limpiar caché
$PHP admin/cli/purge_caches.php

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Caché limpiada exitosamente!"
    echo ""
    echo "📋 Ahora:"
    echo "1. Ve a la página de inicio de Moodle"
    echo "2. Espera 2 segundos"
    echo "3. El modal debe aparecer automáticamente con el video"
    echo ""
    echo "🎯 Para probarlo de nuevo:"
    echo "   En la consola del navegador (F12) ejecuta:"
    echo "   localStorage.removeItem('video_modal_visto')"
    echo "   Luego recarga la página"
else
    echo ""
    echo "❌ Error al limpiar caché"
fi
