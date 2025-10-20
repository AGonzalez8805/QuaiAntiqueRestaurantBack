FROM php:8.2-fpm

# Installe les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libonig-dev libxml2-dev curl gnupg && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install intl pdo pdo_mysql gd zip opcache

# Installe l'extension MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Installe Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copie le code Symfony
WORKDIR /var/www/symfony
COPY . /var/www/symfony

# Donne les bons droits
RUN chown -R www-data:www-data /var/www/symfony

# Expose le port PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
