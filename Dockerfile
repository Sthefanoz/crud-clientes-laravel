# Imagen para publicar la aplicación en Render (o cualquier servicio con Docker)

# Etapa 1: instala las dependencias de producción con la imagen oficial de Composer
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction --ignore-platform-reqs
COPY . .
RUN composer dump-autoload --no-dev --optimize --no-scripts

# Etapa 2: imagen final con PHP (ya incluye SQLite)
FROM php:8.3-cli
WORKDIR /app
COPY --from=vendor /app /app

RUN php artisan package:discover --ansi \
    && chmod +x docker/start.sh

EXPOSE 10000

CMD ["docker/start.sh"]
