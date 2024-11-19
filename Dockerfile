FROM php:8.3.11-apache

RUN apt-get update -y && apt-get install -y \
    openssl \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    mysql-client

RUN docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version  # Verifica la instalación de Composer

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && apt-get install -y nodejs
RUN node -v && npm -v  # Verifica la instalación de Node.js y npm

COPY . /var/www/html
COPY ./public/.htaccess /var/www/html/.htaccess

WORKDIR /var/www/html

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

RUN php artisan install:api
RUN composer require diglactic/laravel-breadcrumbs
RUN composer require barryvdh/laravel-dompdf

RUN php artisan key:generate
RUN php artisan migrate

RUN npm install
RUN npm install vite laravel-vite-plugin
RUN npm run build

RUN chmod -R 777 storage bootstrap/cache

RUN a2enmod rewrite
RUN service apache2 restart

EXPOSE 80