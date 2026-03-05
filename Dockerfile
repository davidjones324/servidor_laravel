# Usar la imagen oficial de PHP con FPM para producción
FROM php:8.3-fpm

# Instalar dependencias del sistema y extensiones de PHP necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nginx

# Limpiar cache de apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Obtener el último Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo
WORKDIR /var/www

# Copiar los archivos del proyecto al contenedor
COPY . /var/www

# Instalar dependencias de PHP con Composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Instalar dependencias selectas de Node para Vite (si es necesario para generar assets en el contenedor)
# NOTA: En servicios como Render, a veces esto se hace fuera, pero dejémoslo listo.
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install \
    && npm run build

# Configurar permisos para carpetas de storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Puerto que expone el contenedor
EXPOSE 80

# Script de inicio para levantar Nginx y PHP-FPM
COPY docker/nginx.conf /etc/nginx/sites-available/default

CMD service nginx start && php-fpm
