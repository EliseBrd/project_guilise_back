FROM php:8.2-cli

# Installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/html

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier le code Symfony
COPY . .

# Installer les dépendances
RUN composer install --no-interaction --optimize-autoloader

# Exposer le port 8000
EXPOSE 8000

# Lancer Symfony et exécuter la migration Doctrine au démarrage
CMD php bin/console doctrine:m:m --no-interaction && php -S 0.0.0.0:8000 -t public