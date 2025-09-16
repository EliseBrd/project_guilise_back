FROM php:8.2-apache

# Installer dépendances utiles
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libpq-dev \
    && docker-php-ext-install intl pdo pdo_mysql

# Activer mod_rewrite pour Symfony
RUN a2enmod rewrite

# Copier les fichiers
WORKDIR /var/www/html
COPY . .

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction

# Droits
RUN chown -R www-data:www-data /var/www/html/var

EXPOSE 8000
CMD ["apache2-foreground"]
