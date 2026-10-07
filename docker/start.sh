#!/bin/sh
# Se ejecuta cada vez que arranca el contenedor
set -e

# Si no se definió APP_KEY, genera una (las sesiones se reinician con cada arranque)
if [ -z "$APP_KEY" ]; then
    export APP_KEY="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
fi

# Base de datos SQLite: se crea vacía y se llena con el admin y los 15 clientes
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --force

# Servidor web en el puerto que asigna Render (10000 por defecto)
exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
