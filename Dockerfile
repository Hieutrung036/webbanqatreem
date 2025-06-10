FROM php:8.2-apache

# Cài extension
RUN apt-get update && apt-get install -y \
    zip unzip curl libpng-dev libonig-dev libxml2-dev libzip-dev libjpeg-dev libfreetype6-dev git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd


# Bật mod_rewrite cho Laravel
RUN a2enmod rewrite

# Đổi DocumentRoot về thư mục public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Sao chép code
WORKDIR /var/www/html
COPY . .

# Cài Composer (nếu chưa có)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cài Laravel & cấp quyền
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

EXPOSE 80
