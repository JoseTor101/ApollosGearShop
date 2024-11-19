FROM php:8.3.11-apache

# Instalar dependencias necesarias
RUN apt-get update -y && apt-get install -y \
    libzip-dev zip unzip git curl \
    && docker-php-ext-install pdo_mysql zip \
    && a2enmod rewrite

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar el código al contenedor
COPY . /var/www/html
WORKDIR /var/www/html

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Cambiar permisos
RUN chmod -R 777 storage bootstrap/cache
