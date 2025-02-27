# Imagen base de PHP con extensiones necesarias
FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev unzip zip

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

RUN apt-get update && apt-get install -y default-mysql-client

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear directorio de la aplicación
WORKDIR /var/www

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias de Laravel
RUN composer install --no-dev --no-scripts --optimize-autoloader

# Permisos para storage y bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache

# Exponer el puerto 9000 (para PHP-FPM)
EXPOSE 9000

