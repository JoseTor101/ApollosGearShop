FROM php:8.3.11-apache
RUN apt-get update -y && apt-get install -y \
    openssl zip unzip git libpng-dev libjpeg-dev libfreetype6-dev \
    zlib1g-dev libzip-dev curl gnupg && \
    docker-php-ext-install pdo_mysql zip gd
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY . /var/www/html
COPY .env /var/www/html/.env
WORKDIR /var/www/html
RUN composer install --ignore-platform-reqs --no-interaction --prefer-dist
RUN npm install
RUN npm run build
RUN php artisan key:generate
RUN php artisan migrate --force 
RUN chmod -R 777 storage bootstrap/cache
RUN a2enmod rewrite
RUN service apache2 restart