FROM php:8.2-apache

# Install SQLite and dev headers
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Enable Apache mod_rewrite (optional but useful)
RUN a2enmod rewrite

# Copy project files
COPY public/ /var/www/html/
COPY src/ /var/www/src/
COPY data/ /var/www/data/

EXPOSE 80